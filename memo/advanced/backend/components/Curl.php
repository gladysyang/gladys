<?php
namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;

//check whether the curl extension for PHP is installed and configured correctly.
if (!function_exists('curl_init')) {
    throw new Exception('Facebook needs the CURL PHP extension.');
}

class Curl extends Component
{
    //config for curl
    public $options;
    public $header = [];
    private $_ch;
    // default config
    private $_config = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36'
    ];

    /**
     * curl exec
     * @param string $url
     * @param bool $removeBom, weather remove BOM
     * @throws Exception
     */
    private function _exec($url, $removeBom = true)
    {
        Yii::trace('Curl excute curl ' . $url, 'system.ext.curl');
        $this->setOption(CURLOPT_URL, $url);
        $c = curl_exec($this->_ch);
        if (!curl_errno($this->_ch)) {
            if ($removeBom) {
                //remove the BOM header
                return substr($c, strpos($c, '{'));
            } else {
                return $c;
            }
        } else {
            throw new Exception(curl_error($this->_ch));
        }
        return false;
    }

    /**
     * Methord get
     * @param string $url
     * @param array $params
     * @param boot $removeBom, weather remove BOM, remove bom because download excel data
     */
    public function get($url, $params = array(), $removeBom = true)
    {
        $this->resetMethodOptions();
        $this->setOption(CURLOPT_HTTPGET, true);

        return $this->_exec($this->buildUrl($url, $params), $removeBom);
    }

    public function post($url, $data = array())
    {
        $this->resetMethodOptions();
        $this->setOption(CURLOPT_POST, 1);
        $this->setOption(CURLOPT_POSTFIELDS, $data);

        return $this->_exec($url);
    }

    public function postJson($url, $data = [])
    {
        return $this->setHeaders(['Content-Type: application/json'])->post($url, $data);
    }

    public function put($url, $data, $params = array())
    {
        // write to memory/temp
        $f = fopen('php://temp', 'rw+');
        fwrite($f, $data);
        rewind($f);

        $this->resetMethodOptions();
        $this->setOption(CURLOPT_PUT, true);
        $this->setOption(CURLOPT_INFILE, $f);
        $this->setOption(CURLOPT_INFILESIZE, strlen($data));

        return $this->_exec($this->buildUrl($url, $params));
    }

    public function putJson($url, $data, $params = [])
    {
        return $this->setHeaders(['Content-Type: application/json'])->put($url, $data);
    }

    //when use Content-Type:application/x-www-form-urlencoded, need to use this function to format the params
    public function formatFormParams($data = array())
    {
        return http_build_query($data);
    }

    public function delete($url, $params = array(), $type = "")
    {
        $this->resetMethodOptions();
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');

        if ($type == "json") {
            $data = Json::encode($params);
            $this->setOption(CURLOPT_POSTFIELDS, $data);
            return $this->_exec($url);
        }
        $this->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        return $this->_exec($this->buildUrl($url, $params));
    }

    public function buildUrl($url, $data = array())
    {
        $parsed = parse_url($url);
        isset($parsed['query']) ? parse_str($parsed['query'], $parsed['query']) : $parsed['query']=array();
        $params = isset($parsed['query']) ? array_merge($parsed['query'], $data) : $data;
        $parsed['query'] = ($params) ? '?' . http_build_query($params) : '';
        if (!isset($parsed['path'])) {
            $parsed['path']='/';
        }

        $linkUrl = '';
        isset($parsed['scheme']) && $linkUrl .= $parsed['scheme'].'://';
        isset($parsed['host']) && $linkUrl .= $parsed['host'];
        isset($parsed['port']) && $linkUrl .= ':' . $parsed['port'];
        isset($parsed['path']) && $linkUrl .= $parsed['path'];
        isset($parsed['query']) && $linkUrl .= $parsed['query'];

        return $linkUrl;
    }

    public function setOptions($options = array())
    {
        curl_setopt_array($this->_ch, $options);

        return $this;
    }

    public function setOption($option, $value)
    {
        curl_setopt($this->_ch, $option, $value);

        return $this;
    }

    public function setHeaders($header = array())
    {
        if ($this->_isAssoc($header)) {
            $out = array();
            foreach ($header as $k => $v) {
                $out[] = $k .': '.$v;
            }
            $header = $out;
        }

        $this->setOption(CURLOPT_HTTPHEADER, $header);

        return $this;
    }

    //check is k-v format
    private function _isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function getError()
    {
        return curl_error($this->_ch);
    }

    public function getInfo()
    {
        return curl_getinfo($this->_ch);
    }

    // initialize curl
    public function init()
    {
        try {
            $this->_ch = curl_init();
            $options = is_array($this->options)? ($this->options + $this->_config) : $this->_config;

            if (defined('KLP') && KLP) {
                $options[CURLOPT_PROXY] = "sgsgprxs000.unileverservices.com";
                $options[CURLOPT_PROXYPORT] = 3128;
            }

            $this->setOptions($options);

            $ch = $this->_ch;

            // close curl on exit
            // Yii::$app->onEndRequest = function() use(&$ch){
            //     curl_close($ch);
            // };
        } catch (Exception $e) {
            throw new Exception('Curl not installed');
        }
    }

    /**
     * Reset all the method options before sending requests
     * @return [type] [description]
     */
    private function resetMethodOptions()
    {
        $this->setOption(CURLOPT_PUT, false);
        $this->setOption(CURLOPT_POST, 0);
        $this->setOption(CURLOPT_CUSTOMREQUEST, null);
        $this->setOption(CURLOPT_HTTPGET, false);
    }

    public function __destruct()
    {
        if ($this->_ch) {
            curl_close($this->_ch);
        }
    }
}

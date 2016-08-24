<?php
namespace backend\utils;

use Yii;
use yii\helpers\Json;

class CreateMenu
{

    const WX_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=';
    const WX_CREATE_MENU = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=';

	  public $appid;
    public $secrect;
    public $accessToken;
 
    function  __construct($appid, $secrect)
    {
        $this->appid = $appid;
        $this->secrect = $secrect;
        $this->accessToken = self::getToken($appid, $secrect);
    }

    /**
     * @param $appid
     * @param $appsecret
     * @return mixed
     * get Token
     */
    public static function getToken($appid, $appsecret)
    {
        /*$access_token = Yii::$app->cache->get('access_token');*/
        if (empty($access_token)) {
            $url = self::WX_TOKEN_URL . $appid . "&secret=" . $appsecret;

            //string(175) "{"access_token":"EKpNdu2eu-JO3Y0rOtdxtUxTwy9iYA8mddJvSUivd_v991qos55lpRAAXgHWnwcRubDiOmDnsJLXleDOBpEZxzmRbVZ3aWe-cF0_8QPKqYio0O0CNKpXT0joqbcvxtXsDYEhABASNT","expires_in":7200}"
            $token = Yii::$app->curl->get($url);
            $arr = json_decode(stripslashes($token), true);
            /*$arr = json_decode(json_encode($token), true);*/
            /*var_dump($token);
            var_dump($arr);
            die();*/
            $access_token = $arr['access_token'];
            $expires_in = $arr['expires_in'];
            Yii::$app->cache->set('access_token',$access_token,$expires_in);  
        }
        return $access_token;
    }
    
    /**
     * template message
     * @param $touser
     * @param $template_id
     * @param $url
     * @param $data
     * @param string $topcolor
     * @return bool
     */
    public function createMenu()
    {
        $jsonMenu = '{
             "button":[
             {  
                  "type":"click",
                  "name":"今日歌曲",
                  "key":"V1001_TODAY_MUSIC"
              },
              {  
                  "type":"click",
                  "name":"已有歌曲",
                  "key":"V1001_TODAY_MUSIC"
              },
              {
                   "name":"菜单",
                   "sub_button":[
                   {    
                       "type":"view",
                       "name":"搜索",
                       "url":"http://www.soso.com/"
                    },
                    {
                       "type":"view",
                       "name":"视频",
                       "url":"http://v.qq.com/"
                    },
                    {
                       "type":"click",
                       "name":"赞一下我们",
                       "key":"V1001_GOOD"
                    }]
               }]
         }'
         ;
        
       /* $json_template = json_encode($template);*/
        $url = self::WX_CREATE_MENU . $this->accessToken;

        $dataRes = json_decode(Yii::$app->curl->postJson($url, urldecode($jsonMenu)), true);

        /*$dataRes = json_decode(json_encode($dataRes), true);*/
       /* var_dump($dataRes['errcode'] == 0);
        die();*/

        
        if ($dataRes['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }
}
<?php
/**
* 
*/
namespace frontend\utils;

use Yii;

class MenuOption
{

	const GET_TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=";
	const CREATE_MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=";
	const GET_MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=";
	const DEL_MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=";

	public $appID;
	public $appsecret;
	public $accessToken;
	
	function __construct($appID, $appsecret)
	{
		$this->appID = $appID;
		$this->appsecret = $appsecret;
		$this->accessToken = self::getToken();
	}

	//获取token的方法
	public function getToken() {
		$access_token = Yii::$app->cache->get("access_token");
		if (empty($access_token)) {
			$url = self::GET_TOKEN_URL . $this->appID . "&secret=" . $this->appsecret;
			$token = Yii::$app->curl->get($url);
			$arr = json_decode($token, true);
			$access_token = $arr["access_token"];
			$expires_in = $arr["expires_in"];
			Yii::$app->cache->set('access_token',$access_token,$expires_in); 
		}

		return $access_token;
	}

	//$data必须是json格式的,创建菜单
	public function createMenu($data) {
		$url = self::CREATE_MENU_URL . $this->accessToken;
		//发送请求后返回的{"errcode":0,"errmsg":"ok"}
		$result = Yii::$app->curl->postJson($url, urldecode($data));
		//将json格式的字符串转化为json格式的数组
		$arr = json_decode($result, true);
		if ($arr['errcode'] == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getMenu() {
		$url = self::GET_MENU_URL . $this->accessToken;
		$result = Yii::$app->curl->get($url);
		return $result;
	}

	public function delMenu($data) {
		$url = self::DEL_MENU_URL . $this->accessToken;
		$result = Yii::$app->curl->delete($url, $data);
		$arr = json_decode($result, true);
		if ($arr['errcode'] == 0) {
			return true;
		} else {
			return false;
		}
	}
}
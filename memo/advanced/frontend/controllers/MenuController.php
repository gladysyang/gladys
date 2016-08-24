<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\utils\MenuOption;

/**
* 
*/
class MenuController extends Controller
{

	public function actionCreate() 
	{
		$data ='{
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
                       "type":"view",
                       "name":"便签",
                       "url":"http://192.168.222.54:8888/memo/to-show"
                    }]
               }]
         }';
		$createMenu = new MenuOption("wxf37480020663eefe", "7bb42033168fc172978d28593f4049fa");	
		$flag = $createMenu->createMenu($data);

		if ($flag) {

			return "success";
		} else {

			return "fail";
		}
	}

  public function actionGet() {
    $menu = new MenuOption("wxf37480020663eefe", "7bb42033168fc172978d28593f4049fa"); 
    $result = $menu->getMenu();
  }

  public function actionDel() {
    $data ='{
             "button":[
              {  
                  "type":"click",
                  "name":"已有歌曲",
                  "key":"V1001_TODAY_MUSIC"
              }
           ]
         }';
        /* var_dump($data);
    var_dump(json_decode($data, true));
    die();*/
    $menu = new MenuOption("wxf37480020663eefe", "7bb42033168fc172978d28593f4049fa"); 
    $flag = $menu->delMenu(json_decode($data, true));

    if ($flag) {

      return "success";
    } else {

      return "fail";
    }
  }
}
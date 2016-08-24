<?php
/**
* 
*/
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\utils\CreateMenu;


class MenuController extends Controller
{

	public function actionToShow() 
	{
		$createMenu = new CreateMenu("wxf37480020663eefe", "7bb42033168fc172978d28593f4049fa");
		$result = $createMenu->createMenu();
		if ($result == true) {
			return "success";
		} else {
			return "fail";
		}
	}

	public function actionTest() {
		return "ok";
	}


}
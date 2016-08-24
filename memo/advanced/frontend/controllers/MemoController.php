<?php
/**
* 
*/
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Memo;

class MemoController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionToShow() 
	{	
		/*echo phpinfo();*/
		$data['memos'] = Memo::findMemos();

		return $this->render("show", $data);
	}

	public function actionToAdd() 
	{
		return $this->render("add");
	}

	public function actionAdd() 
	{
		$content = $_POST['edit_content'];
		$clock = $_POST['clock'];
		if (!empty(trim($content)))
		{
			Memo::saveMemo($content, $clock);

			return $this->redirect('/memo/to-show');
		} else {
			$data['message'] = "请输入内容";

			return $this->render("add");
		}
	}

	public function actionBatchDel() 
	{
		$delStr = $_POST['idArr'];
		$arrDel = explode(",", $delStr);
		if (count($arrDel) > 0) 
		{
			for ($i = 0; $i < count($arrDel); $i++)
			{
				Memo::deleteMemo($arrDel[$i]);
			}

			return $this->redirect("/memo/to-show");
		}
	}

	public function actionDel() 
	{
		$id = $_GET['id'];
		if (!empty($id)) {
			Memo::deleteMemo($id);
		} else {

			return $this->redirect("/memo/to-show");
		}

		return $this->redirect("/memo/to-show");
	}

	public function actionDetail() 
	{
		$id = $_GET['id'];
		$data['memo'] = Memo::getMemo($id);
		if (!empty($data['memo']->clock)) {
			$data['memo']->clock = self::is_timeout($data['memo']->clock);
		}

		return $this->render("detail", $data);
	}

	public function actionToUpdate() 
	{
		$id = $_GET['id'];
		if (!empty($id)) {
			$data['memo'] = Memo::getMemo($id);
			if (!empty($data['memo']->clock)) {
				$data['memo']->clock = self::is_timeout($data['memo']->clock);
			}
			
			return $this->render("update", $data);
		} 

		return $this->render("add");
	}

	public function actionUpdate() 
	{
		$id = $_POST['id'];
		$content = $_POST['edit_content'];
		$clock = $_POST['clock'];
		if (!empty(trim($content)))
		{
			Memo::updateMemo($id, $content, $clock);

			return $this->redirect('/memo/to-show');
		} else {
			$data['message'] = "请输入内容";

			return $this->render("update");
		}
	}

	public static function is_timeout($clock) {
		$now = date("Y/m/d H:i");

		//判断提醒时间是否已过时
		if (strtotime($clock) < strtotime($now)) 
		{
			$clock = '已过时';
		}

		return $clock;
	}
}
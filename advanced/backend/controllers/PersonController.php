<?php
/**
 * 
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Person;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\web\Request;

 class PersonController extends Controller
 {
 	
 	public function rules()
    {
        return [
            ['name', 'age', 'gender', 'deleted']
        ];
    }

    public function actionAll() {
    	$data['person']  = Person :: findPersons();
        return $this->renderPage("show", $data);
    }

    public function actionSave() {
    	$request  = Yii::$app->request;
    	$name = $request->post('name');
    	$age = $request->post('age');
    	$gender = $request->post('gender');
    	$person = new Person();
    	$person->name = $name;
		$person->age = $age;
		$person->gender = $gender;
		$person->deleted = '-1';
		$person->save();
    }

    public function actionDel($id) {
    	$person = new Person();
    	$person -> deletePerson($id);
    }

    public function actionUp($id, $name, $age, $gender) {
    	$person = new Person();
    	$person -> updatePerson($id, $name, $age, $gender);
    }

    public function actionSel($name) {
    	$person = new Person();
    	$person -> getPersonByName($name);
    	return $person;
    }

    private function renderPage($page, $data)
    {
         const MODULES_BUILD_PATH = '/';
        $actionName = $this->action->id;
        $pageJsFileName = empty($actionName) ? 'app' : $actionName;

        if (!empty($page)) {
            $pageJsFileName = $pageJsFileName . ucfirst($page);
        }

        //Inject page js & css files
        $this->registerCssFile(self::MODULES_BUILD_PATH . 'css/'.$pageJsFileName.'.css');
/*        $this->registerBodyJsFile(self::VENDER_PATH . "an.js");
        $this->registerBodyJsFile(self::MODULES_BUILD_PATH . "js/$pageJsFileName.js");*/

        return $this->render($actionName . '/' . $page, $data);
    }
 } 
<?php

namespace frontend\models;

use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use yii\mongodb\QueryTrait;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\data\Sort;



class Person extends ActiveRecord
{
	use Email;
	 /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'person';
    }

    /*scenarios() 方法默认实现会返回所有yii\base\Model::rules()方法申明的验证规则中的场景*/
    /*public function scenarios() {
    	return [
    		self::SCENARIOS_ADD => ['name', 'age', 'gender'],
    	];
    }*/

    /**/
    public function rules() {
    	return [
    		[['name', 'age', 'gender'], 'required'],
    		['age', 'number', 'min' => 10, 'max' => 100],
    		[['imageFile'],'file', /*'skipOnEmpty'=>false, */'extensions'=>'png, jpg'],
    		/*提供一个特别的别名为 safe 的验证器来 申明哪些属性是安全的不需要被验证*/
    		/*['gender', 'safe']*/
    	];
    }

    public function attributes()
    {
        return ['_id', 'name', 'age', 'gender', 'deleted', 'create_at', 'updated_at', 'imageFile'];
    }

	/*behavior*/
    public function behaviors() {
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes'=>[
					ActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}

	public function findPersons() {
		$persons = Person::find() -> Where(['deleted' => '-1']);
		return $persons;
	}

	public function getPerson($id) {
		$person = Person:: findOne(['_id' => $id]);
		return $person;
	}

	public function savePerson($name, $age, $gender, $imageFile) {
		$person = new Person();
		$person->name = $name;
		$person->age = $age;
		$person->gender = $gender;
		$uploadpath = $person->fileExist('images/'.date('Ymd').'/');
		$person->imageFile = $uploadpath.$imageFile;
		$person->deleted = '-1';
		/*所有输入数据都有效 all inputs are valid*/
		if ($person->validate()) {
			
			$person->insert();

			//显示当前的时间戳
			//var_dump(date('Y-m-d H:i:s',$person->create_at));
			return 'add successful';
		} else {
			/*验证失败：$errors 是一个包含错误信息的数组*/
			/*$errors = $person->errors;*/
			return 'add failed';
		}
	}

	public function deletePerson($person) {
		$person -> deleted = '1';
		$person -> update();
	}

	public function updatePerson($id,$name, $age, $gender, $imageFile) {
		$person = Person:: findOne(['_id' => $id]);
		$person->name = $name;
		$person->age = $age;
		$person->gender = $gender;
		//获取已经添加用户的头像路径
		$uploadpath = dirname($person->imageFile). '/';
		$person->imageFile = $uploadpath.$imageFile;
		if ($person->validate()) {
			$person -> update();
			//显示当前的时间戳
			//var_dump(date('Y-m-d H:i:s',$person->create_at));
			return 'add successful';
		} else {
			/*验证失败：$errors 是一个包含错误信息的数组*/
			/*$errors = $person->errors;*/
			return 'add failed';
		}
	}

	public function getPersonByName($name) {
		if (is_null($name)) {
			$name = '';
		}
		$person = Person::find()->where(['and', ['deleted' => '-1'],['like', 'name', $name]]);
		return $person;
    }

    public function fileExist($uploadpath) {
    	if (!file_exists($uploadpath)) {
    		mkdir($uploadpath);
    	}
    	return $uploadpath;
    }
}
<?php
namespace frontend\models;

use yii\mongodb\ActiveRecord;
use yii\validators\StringValidator;
use yii\validators\EmailValidator;
use yii\validators\UniqueValidator;
use yii\web\IdentityInterface;
/**
* 
*/
class User extends ActiveRecord
{
    
    public static function collectionName() {
        return "user";
    }

    public function scenarios() {
        return [
            'register' => ['name', 'password', 'email'],
            'login' => ['name', 'password'],
        ];
    }

	public function rules() {
		return [
			[['name', 'password'], 'required','on'=>'login'],
    		[['name', 'password', 'email'], 'required', 'message'=>'{attribute}不能为空'],
    		[['name', 'email'],'unique', 'message'=>'{attribute}已经被占用'],
    		['name', 'string', 'min'=>5, 'max'=>16, 'message'=>'{attribute}的长度必须在3~16之间'],
    		['email', 'email', 'message'=>'请输入正确的{attribute}'],
    		['password', 'string', 'min'=>8, 'max'=>16, 'message'=>'{attribute}的长度必须在8~16之间',],
    	];
	}

	public function attributes() {
		return ['_id', 'name', 'password', 'email'];
	}

	public function getUser($name, $password) {
		$user = User::findOne(['name'=>$name, 'password'=>$password]);
		return $user;
	}

	//将user对象保存到mongo数据库中
	public function saveUser($user) {
		if ($user->validate()) {
			$user->insert();
		} else {
			return $user->errors;
		}
	}

	//验证邮箱
	public function emailValidator($email) {
		$validator = new EmailValidator();
		if ($validator->validate($email, $error)) {
			return 'success';
		} else {
			return $error;
		}
	}
}
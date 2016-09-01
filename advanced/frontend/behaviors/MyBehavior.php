<?php

namespace frontend\behaviors;

use yii\base\Behavior;
/**
* 
*/
class MyBehavior extends Behavior
{
	
	public $property = "this is a behavior";

	public function method1() {
		return 'this is a method';
	}
}
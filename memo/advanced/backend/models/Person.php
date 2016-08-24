<?php
	/**
	* 
	*/
namespace backend\models;

use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;

class Person extends ActiveRecord
{
	 /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'person';
    }

    public function rules()
    {
        return [
            ['_id', 'name', 'age', 'gender', 'deleted']
        ];
    }

    public function attributes()
    {
        return ['_id', 'name', 'age', 'gender', 'deleted'];
    }

	public function findPersons() {
		$persons = Person::find() -> where(['deleted' => '-1']) -> all();
		return $persons;
	}

	public function getPerson($id) {
		$person = Person:: findOne(['_id' => $id]);
		return $person;
	}

	public function savePerson($name, $age, $gender) {
		$person = new Person();
		$person->name = $name;
		$person->age = $age;
		$person->gender = $gender;
		$deleted->deleted = '-1';
		$person->save();
	}

	public function deletePerson($id) {
		$person = Person::findOne(['_id' => $id]);
		$person -> deleted = '1';
		$person -> update();
	}

	public function updatePerson($id, $name, $age, $gender) {
		$person = Person::findOne(['_id' => $id]);
		$person -> name = $name;
		$person -> age = $age;
		$person -> gender = $gender;
		$person -> deleted = '-1';
		$person -> update();
	}

	/*public function getPersonByName($name)
    {
        $query=array("name"=>new MongoRegex("/.*”.$name.".));
		return $db -> find($query);
    }*/
}
<?php
/**
* 
*/
namespace frontend\models;

use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use yii\data\Sort;

class Memo extends ActiveRecord
{
	 /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'memo';
    }

    public function attributes()
    {
        return ['_id', 'content', 'date','clock'];
    }

    public function findMemos() 
    {
    	$sort = new Sort([
    		'attributes' => [
	    		'date'=> [
	    			'asc' => ['date' => SORT_ASC],
	    			'desc' => ['date' => SORT_DESC],
	    			'default' => SORT_DESC,
	    			],
	    		],
    		]);
    		
    	$memos = Memo::find()->orderBy(['date' => SORT_DESC])->All();
    	return $memos;
    }

    public function saveMemo($content, $clock) 
    {
        $clock = self::getClock($clock);

    	$memo = new Memo();
    	$memo->content = $content;
        $memo->date = date("Y/m/d H:i");
        $memo->clock = $clock;
    	return $memo->save();
    }

    public function deleteMemo($id)
    {
    	$memo = Memo::findOne($id);
    	$memo->delete();
    }

    public function updateMemo($id, $content, $clock) 
    {
        $clock = self::getClock($clock);

    	$memo = Memo::findOne($id);
    	$memo->content = $content;
    	$memo->date = date("Y/m/d H:i");
        $memo->clock = $clock;
    	$memo->update();
    }

    public function getMemo($id) {
    	return Memo::findOne($id);
    }

    public static function getClock($clock) {
        if (preg_match('/T/', $clock)) 
        {
            $clock = str_replace('T',' ', $clock);

            return $clock;
        } else {

            return $clock;
        }
    }
}
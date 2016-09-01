<?php
/**
 * 
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Person;
use yii\data\Sort;
use yii\helpers\Inflector;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\mongodb\Query;

 class PersonController extends Controller
 {
    public $enableCsrfValidation = false;

 	public function rules()
    {
        return [
            ['name', 'age', 'gender', 'deleted']
        ];
    }

    public function actionAll() {
        $cookies = Yii::$app->request->cookies;
        
        if ($cookies->has('user')) {

            $data['person']  = Person::findPersons();
            $data = $this->paginationAndSort($data['person']);
            return $this->render("show", $data);
        }
        return $this->redirect("/user/login");
    }

    public function actionAdd() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('user')) {
            return $this->render("add");
        }
        return $this->redirect("/user/login");
        
    }

    public function actionSave() {
    	$request  = Yii::$app->request;
    	$name = $request->post('name');
    	$age = $request->post('age');
    	$gender = $request->post('gender');
        $imageFile = $_FILES["imageFile"]["name"];
        $data['message'] = Person::savePerson($name, $age, $gender, $imageFile);

        if ($data['message'] === 'add successful') {
            move_uploaded_file($_FILES['imageFile']['tmp_name'], './images/'.date("Ymd").'/'.$imageFile);
        }
        return $this->render('add', $data);
    }

    public function actionDel() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('user')) {
            $request = Yii::$app->request;
            $id = $request->get('_id');
            $person = Person::getPerson($id);
            Person::deletePerson($person);
            return $this->redirect('/person/all');
        }
        return $this->redirect("/user/login");
    }

    public function actionToUpdate() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('user')) {
            $request = Yii::$app->request;
            $id = $request->get('_id');
            $data['person'] = Person::getPerson($id);
            $imageFile = $data['person']['imageFile'];
            $data['image'] = basename($imageFile);
            return $this->render('update', $data);
        }
        return $this->redirect("/user/login");
    }

    public function actionUpdate() {
        $request  = Yii::$app->request;
        $id = $request->post('id');
        $name = $request->post('name');
        $age = $request->post('age');
        $gender = $request->post('gender');
        $imageFile = $_FILES['imageFile']['name'];
        $uploadpath = $request->post('hidden-imageFile');

        if (empty($imageFile)) {
            $imageFile = basename($uploadpath);
        }
        $data['message'] = Person::updatePerson($id, $name, $age, $gender, $imageFile);

        if ($data['message'] === 'add successful') {
            move_uploaded_file($_FILES['imageFile']['tmp_name'], dirname($uploadpath).'/'.$imageFile);
        }
        return $this->redirect('/person/all');
    }

    public function actionSel() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('user')) {
            $request = Yii::$app->request;
            $keyword = $request->get('select');

            $data['person'] = Person::getPersonByName($keyword);

            $data = $this->paginationAndSort($data['person']);
            $data['keyword'] = $keyword;
            return $this->render("show", $data);
        }
        return $this->redirect("/user/login");
    }

    public function actionToImport() {
        return $this->render('batch_add');
    }

    public function actionImport() {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        //判断是否选择了上传的文件
        if (empty($fileName)) {
            $data['message'] = "请选择要上传的文件";
            return $this->render("batch_add", $data);
        }
        //判断选择上传的文件是不是csv格式
        if (explode(".", $fileName)[1] != "csv") {
            $data['message'] = "请选择csv格式的文件上传";
            return $this->render("batch_add", $data);
        } 

        //创建一个空数组，预放imageUrl
        $imageCollection = [];
        //打开要读的文件
        $handle = fopen($fileTmpName, 'r');
        $flag = 0;
        //解析csv文件
        while (!feof($handle)) {
            //fgets方法按行读
            $result = fgets($handle);
            ++ $flag;

            if ($flag == 1 && empty($result)) {
                $data['message'] = "没有数据，请重新上传数据";
                return $this->render("batch_add", $data);
            }
            //判断读到的每一行是否有值
            if (!empty($result)) {
                $arrResult = explode(",", $result);
                $name = $arrResult[0];
                $age = $arrResult[1];
                $gender = $arrResult[2];
                //图片的原路径
                $imagePath = $arrResult[3];
                //图片的名字
                $image = basename($imagePath);

                $data['message'] = Person::savePerson($name, $age, $gender, $image);

                if ($data['message'] == 'add successful') {
                    //将每个图片的uri放到数组中
                    array_push($imageCollection, $imagePath);
                }
            } 
        }
        //关闭文件流
        fclose($handle);

        //关闭文件流之后才能上传图片，注意：流和流是不能嵌套使用的
        if (!empty($imageCollection)) {

            foreach ($imageCollection as $value) {
                //将图片上传到服务器上,j
                move_uploaded_file($imagePath, dirname(__DIR__) . '/web/images/'.date("Ymd").'/'.$image);
            }
        }
        return $this->render("batch_add", $data);
    }

    public function paginationAndSort($person) {
        //排序
        $sort = new Sort([
            'attributes' => [
                'age' => [
                    'asc' => ['age' => SORT_ASC],
                    'desc' => ['age' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => '年龄'
                    /*'label' => Inflector::camel2words('age'),*/
                ],
                'name'=>[
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => '姓名'
                ],
            ],
            //默认按id排序，现在改成按age排序
            /*'defaultOrder' => ['name' => SORT_ASC],*/
        ]);
        $data['name'] = $sort->link('name');
        $data['age'] = $sort->link('age');

        //分页
        $data['pagination'] = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $person->count(),
        ]);
        
        //$data['person']必须是一个Query对象，才可以调用orderBy(),offset(),limit()等方法
        $data['persons'] = $person->orderBy($sort->orders)
            ->offset($data['pagination']->offset)
            ->limit($data['pagination']->limit)
            ->all();
        return $data;
    }
 } 
<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\Session;
use yii\web\Cookie;
use frontend\behaviors\MyBehavior;
use yii\base\Component;

/**
* 
*/
class UserController extends Controller
{
	/*每个控制器都有一个由 yii\base\Controller::defaultAction 属性指定的默认操作， 当路由只包含控制器ID， 会使用所请求的控制器的默认操作。
	默认操作默认为 index，如果想修改默认操作， 只需简单地在控制器类中覆盖这个属性*/
	/*public $defaultAction = 'login';*/
	public $enableCsrfValidation = false;

	public function rules()
    {
        return [
            ['name', 'password']
        ];
    }

	public function actionLogin() {
		$cookies = Yii::$app->request->cookies;

		if (isset($cookies['user'])) {
			return $this->redirect('/person/all');
		}

		return $this->render("login");
	} 

	public function actionLog() {
		$request = Yii::$app->request;
		$name = $request->post('name');
		$password = $request->post('password');
		$checkbox = $request->post('checkbox');
		$user = User::getUser($name, $password); 
		//指定场景
	/*	$user->setScenario('login');
*/
		if (empty($user)) {
			$data['message'] = 'name or password is wrong';
			return $this->render("login", $data);
		}

		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
		'name' => 'user',
	    'value' => $user,
	    'expire'=>time()+3600

		]));

		//记住密码
		if ($checkbox == 'checked') {
			$cookies = Yii::$app->response->cookies;
				$cookies->add(new \yii\web\Cookie([
				'name' => 'name',
			    'value' => $name,
			    'expire'=>time()+3600
				]));
				$cookies->add(new \yii\web\Cookie([
				'name' => 'password',
			    'value' => $password,
			    'expire'=>time()+3600
				]));
		}
		
		return $this->redirect('/person/all');
	}
	
	public function actionToRegister() {
		return $this->render('register');
	}

	public function actionRegister() {
		$request = Yii::$app->request;
		$name = $request->post('name');
		$password = $request->post('input_password');
		$confirm_password = $request->post('confirm_password');
		$email = $request->post('email');

		if (trim($password) !== trim($confirm_password)) {
			$data['confirm_password'] = '请再输入确认密码';
		}

		$user = new User();
		$user->name = $name;
		$user->password = $password;
		$user->email = $email;
		//设置场景
		$user->setScenario('register');
		$data['message'] = User::saveUser($user);

		if (!empty($data['message']) || !empty($data['confirm_password'])) {
			return $this->render('register', $data);
		} else {
			return $this->render('login');
		}
	}

	public function actionLogout() {
		$cookies = Yii::$app->request->cookies;
		if ($cookies->has('user')) {
			Yii::$app->response->cookies->remove('user');
			return $this->redirect('/user/login');
		}
		//如果cookie过期了，当点击logout时，系统跳到登陆界面
		return $this->redirect('/user/login');
	}

	public function actionToForget() {
		return $this->render('forget');
	}

	//忘记密码
	public function actionForget() {
		$request = Yii::$app->request;
		$emailAddress = $request->post('email');
		//调用User类中的emailValidator方法，判断用户输入的邮箱地址格式是否正确
		$message = User::emailValidator($emailAddress);

		if ($message === 'success') {
			//如果邮箱地址格式正确，写邮箱内容
			$mail = Yii::$app->mailer->compose(
				/*['html' => 'contact-html',
				'text' => 'contact-text'],
				'embed-email', ['imageFileName' => '/home/user/workspace/YIILearn/advanced/frontend/web/static/images/add_user_33.338595106551px_1200609_easyicon.net.png']*/);
			$mail->setTo($emailAddress);
			$mail->setSubject('找回密码');
			$mail->setHtmlBody('<font>please click this link</font><br><a href="">iajeijfajfkajfdkjfjdf</a>
				 ');
			
			//添加本地附件
			/*$mail->attach("/home/user/note/note");*/
			//动态创建一个附件
			$mail->attachContent('Attachment content', ['fileName' => 'attach.txt', 'contentType' => 'text/plain']);

			//发送图片
			/*$mail->embed("http://localhost:7777/static/images/add_user_33.338595106551px_1200609_easyicon.net.png");
*/
			try {
				//发送邮件
				if ($mail->send()) {
					//如果邮件发送成功，解析邮箱地址，拼接成一个url
					$emailArr = explode("@", $emailAddress); 
					$emailUrl = 'https://mail.' . $emailArr[1];
					//然后判断url是否存在
					if ($this->url_exists($emailUrl)) {
						//如果存在，我在邮件发送成功界面出现一个链接
						$data['url'] = $emailUrl;
						return $this->render('success', $data);
					}
					//否则直接跳到邮件发送成功界面
					return $this->render('success');
				} 
			//  "\"默认在系统中找Swift_TransportException
			} catch (\Swift_TransportException $e) {
				$data['message'] = '邮件发送失败，请检查网络是否正常';
				return $this->render('forget', $data);
			}
		} else {
			//如果输入的邮箱错误，还是回到发送邮箱界面
			return $this->render('forget', ['message'=>'请输入正确的邮箱']);
		}
	}

	//判断网址是否存在
	public function url_exists($url) {
		$check = @fopen($url,"r");
		if($check)
		$status = true;
		else
		$status = false;
		return $status; 
	}
}
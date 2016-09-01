<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    /*区分其他应用的唯一标识ID*/
    'id' => 'app-frontend',
    /*指定该应用的根目录。*/
    'basePath' => dirname(__DIR__),
    /*保证了 log 组件一直被加载*/
    'bootstrap' => ['log'],
    /*如果传入请求并没有提供一个具体的路由，（一般这种情况多为于对首页的请求）此时就会启用由 yii\web\Application::defaultRoute 属性所指定的缺省路由。 该属性的默认值为 site/index，它指向 site 控制器的 index 操作,change*/
    'defaultRoute' => 'user/login',

    'controllerNamespace' => 'frontend\controllers',
    /*第一次访问时实例化*/
    'components' => [
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        /*处理 PHP 错误和异常*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        支持URL地址解析和创建*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],
    ],
    'params' => $params
];

<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            // following line will restrict access to admin page
            //'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class'=>'yii\web\UrlManager',
            'rules'=>[
                    '' => 'site/index',
                    '<action:(login|logout|addmarks)>' => 'site/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.ukraine.com.ua',
                'username' => 'service@erste.com.ua',
                'password' => '43g3ifs5dG*f',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
    'params' => $params,
];

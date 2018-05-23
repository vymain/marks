<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
	    'user' => [
	        'class' => 'dektrium\user\Module',
	        // you will configure your module inside this file
	        // or if need different configuration for frontend and backend you may
	        // configure in needed configs
	    ],
	],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=adv',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];

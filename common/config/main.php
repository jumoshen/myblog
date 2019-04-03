<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name'=>'巨魔客',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=myblog',
            'username' => 'lianghui',
            'password' => 'lh951121',
            'charset' => 'utf8',
            'enableSchemaCache' => false,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',            
        ],
	'noteDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=myNote',
            'username' => 'lianghui',
            'password' => 'lh951121',
            'charset' => 'utf8',
            'enableSchemaCache' => false,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
	'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                'useFileTransport' => false,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.qq.com',
		    'username' => '1173240549@qq.com',
                   # 'password' => 'yuqfukrowfocdjhb',
		    'password' => 'mstheiicudpchgdf',
                    'port' => '465',
                    'encryption' => 'ssl',  
                   // 'username' => 'service@weisi360.com',
                   // 'password' => 'weisi2014',
                    //'port' => '25',
                    //'encryption' => 'ssl',   
                ],
        ],
        'redis' => [
                'class' => 'yii\redis\Connection',
                'hostname' => '127.0.0.1',
                'port' => 6379,
                'database' => 0,
		'password' => 'lh951121',
        ],
	'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['guest'],
        ],
        'user' => [
            'identityClass' => 'backend\models\Manager',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'suffix'=>'.html',
            'showScriptName'=>false,
            'rules' => [
            ],
            // ...
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],                   
    ],
    'language' => 'zh-CN',
    'defaultRoute' => '/site/index',
    //'params' => $params,
];


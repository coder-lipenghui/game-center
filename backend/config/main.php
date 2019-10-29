<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin'=>[
            'class'=>'mdm\admin\Module',
        ]
    ],
    'language'=>'zh-CN',
    'aliases'=>[
        '@mdm/admin'=>"@vendor/mdm/yii2-admin-2.9"
    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'site/logout',
            'site/login',
            'center/*',
            'permission/*',
        ]
    ],
    'components' => [
        "authManager" => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles'=>['guest'],
            'itemTable'=>'auth_item',
            'assignmentTable'=>'auth_assignment',
            'itemChildTable'=>'auth_item_child',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['payment'],
                    'levels' => ['error'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/payment.log',//TODO 后面使用匿名函数将log按照日期来划分
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['login'],
                    'levels' => ['error'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/login.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['order'],
                    'levels' => ['error'],
//                    'logVars' => ['_POST','_GET','_FILES','_COOKIE'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/order.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['cdkey'],
                    'levels' => ['error'],
//                    'logVars' => ['_POST','_GET','_FILES','_COOKIE'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/cdkey.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing'=>false,
            'showScriptName' => false,
            'suffix'=>'',
            'rules' => [
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                'center/<controller:\w+>/payment-callback/<distributionId:\d+>'=>'center/<controller>/payment-callback',
            ],
        ],
    ],
    'params' => $params,
];

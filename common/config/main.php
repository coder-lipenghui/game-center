<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=qiyou_center',
            'username' => 'root',
            'password' => '7youNew7DBs',
            'charset' => 'utf8',
        ],
        'cache' => [
//            'class' => 'yii\caching\FileCache',
            'class'=>'yii\caching\MemCache',
        ],
    ],

];

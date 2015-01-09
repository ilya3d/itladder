<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user','moder','admin'], // Здесь нет роли "guest", т.к. эта роль виртуальная и не присутствует в модели UserExt
        ],
    ],
];

<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'formatter' => [
            'dateFormat' => 'php:d.m.Y',
        ],
        'i18n' => array(
            'translations' => array(
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => dirname(dirname(__DIR__)).'/messages',
                    'fileMap' => [
                        'app/menu' => 'menu.php',
                        'app/profile' => 'profile.php',
                        'app/blog' => 'blog.php',
                    ],
                ],
                'eauth' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ),
            ),
        ),
        'eauth'=> [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ],
            'services'=>[
                'twitter' => [
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                ],
                'vkontakte' => [
                    'class' => 'nodge\eauth\services\VKontakteOAuth2Service',
                ],
                'redmine' => [
                    'class' => 'common\components\oauth\RedmineOAuth1Service',
                ]
            ]
        ],
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
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/eauth.log',
                    'categories' => ['nodge\eauth\*'],
                    'logVars' => [],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
                'gii' => 'gii',
                'profile' => 'profile/list',
                'profile/<user:[\w\.]+>' => 'profile/index',
                'profile/<user:[\w\.]+>/edit' => 'profile/edit',
                'blog/<user:[\w\.]+>/create' => 'blog/create',
                'blog/<user:[\w\.]+>/<id:\w+>/update' => 'blog/update',
                'blog/<user:[\w\.]+>/<id:\w+>/delete' => 'blog/delete',
                'blog/<user:[\w\.]+>/<id:\w+>' => 'blog/view',
                'blog/<user:[\w\.]+>' => 'blog/index',
                'list' => 'profile/list',
                'generate' => 'profile/generate',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                'login/<service:google|facebook|etc|twitter>' => 'site/login',
                ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

    ],
    'params' => $params,
];

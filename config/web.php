<?php

use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';

return [
    'id' => 'basic',
    'name' => 'Калькулятор',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main',
    'language' => 'ru',
    'defaultRoute' => 'calculator/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
            'parsers' => ['application/json'  => JsonParser::class]
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
            'showScriptName' => false,
            'rules' => [
                // ...
            ],
        ],
    ],
    'params' => $params,
];

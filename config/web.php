<?php

use yii\web\JsonParser;
use yii\web\Response;

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
        'db' => require __DIR__ . '/db.php',
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
            'parsers' => ['application/json'  => JsonParser::class]
        ],
        'response' => [
            'class' => Response::class,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->statusCode === 400 || $response->statusCode === 401 || $response->statusCode === 404) {
                    $response->data = [
                        'message' => $response->data['message'],
                    ];
                }
            },
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
                'api/v2/months' => 'api/v2/month/index',
                'api/v2/tonnages' => 'api/v2/tonnage/index',
                'api/v2/types' => 'api/v2/type/index',
                'api/v2/prices' => 'api/v2/price/index'
            ],
        ],
    ],
    'params' => $params,
];

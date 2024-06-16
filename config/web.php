<?php

use yii\web\ErrorHandler;
use yii\web\JsonParser;
use yii\web\Response;

$params = require __DIR__ . '/params.php';

return [
    'id' => 'basic',
    'name' => 'Калькулятор',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'mvc'],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module'
        ],
        'mvc' => [
            'class' => 'app\modules\mvc\Module'
        ]
    ],
    'layout' => 'main',
    'language' => 'ru',
    'defaultRoute' => 'site/index',
    'container' => [
        'singletons' => [
            \app\repositories\interfaces\MonthRepositoryInterface::class => \app\repositories\SqlMonthRepository::class,
            \app\repositories\interfaces\TonnageRepositoryInterface::class => \app\repositories\SqlTonnageRepository::class,
            \app\repositories\interfaces\TypeRepositoryInterface::class => \app\repositories\SqlTypeRepository::class,
            \app\repositories\interfaces\PriceRepositoryInterface::class => \app\repositories\SqlPriceRepository::class
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['user/login'],
            'enableAutoLogin' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
            'parsers' => ['application/json'  => JsonParser::class]
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'errorHandler' => [
            'errorAction' => 'calculator/error',
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
                'api/v2/prices' => 'api/v2/price/index',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['api\v2\months', 'api\v2\tonnage', 'api\v2\type', 'api\v2\price']]
            ],
        ],
    ],
    'params' => $params,
];

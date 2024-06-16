<?php

use yii\web\Response;
use yii\web\JsonParser;

return [
    'components' => [
        'response' => [
            'class' => Response::class,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->statusCode === 400 || $response->statusCode === 401 || $response->statusCode === 404) {
                    $response->data = [
                        'message' => $response->data['message'],
                    ];
                }
            }
        ]
    ]
];

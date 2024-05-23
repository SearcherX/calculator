<?php

namespace app\components\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class TokenAuthMiddleware extends ActionFilter
{
    public function beforeAction($action): bool
    {
        $token = Yii::$app->request->headers->get('X-Api-Key');

        if ($token !== $_ENV['X-API-KEY']) {
//            var_dump($token);
            var_dump($_ENV['X-API-KEY']);
            die();
//            throw new UnauthorizedHttpException('Авторизация не выполнена');
        }

        return true;
    }
}
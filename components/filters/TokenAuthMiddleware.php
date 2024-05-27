<?php

namespace app\components\filters;

use Dotenv\Dotenv;
use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

global $projectRoot;
$projectRoot = Yii::getAlias('@app');

class TokenAuthMiddleware extends ActionFilter
{
    public function beforeAction($action): bool
    {
        global $projectRoot;
        $token = Yii::$app->request->headers->get('X-Api-Key');

        $dotenv = Dotenv::createMutable($projectRoot);
        $dotenv->load();

        if ($token !== getenv('X_API_KEY')) {
            throw new UnauthorizedHttpException('Авторизация не выполнена');
        }

        return true;
    }
}
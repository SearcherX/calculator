<?php

namespace app\components\filters;

use Composer\Util\Http\Response;
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
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        global $projectRoot;
        $token = Yii::$app->request->headers->get('X-Api-Key');

        $dotenv = Dotenv::createMutable($projectRoot);
        $dotenv->load();

        if ($token !== getenv('X_API_KEY')) {
            throw new UnauthorizedHttpException('Авторизация не выполнена');
        }

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            return true;
        }

        return true;
    }
}
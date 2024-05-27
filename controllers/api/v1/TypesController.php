<?php

namespace app\controllers\api\v1;

use app\components\filters\TokenAuthMiddleware;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class TypesController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return ['class' => TokenAuthMiddleware::class, 'verbFilter' => ['class' => VerbFilter::class, 'actions' => ['index' => ['get']]]];
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return Yii::$app->params['lists']['raw_types'];
    }
}
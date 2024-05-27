<?php

namespace app\controllers\api\v1;

use app\components\filters\TokenAuthMiddleware;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class PricesController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return ['class' => TokenAuthMiddleware::class, 'verbFilter' => ['class' => VerbFilter::class, 'actions' => ['index' => ['get']]]];
    }

    public function actionIndex($month, $type, $tonnage)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($month === null
            || $type === null
            || $tonnage === null
            || empty($month)
            || empty($type)
            || empty($tonnage)
            || isset(Yii::$app->params['prices'][$type][$month][$tonnage]) === false) {
            throw new \yii\web\NotFoundHttpException("Стоимость для выбранных параметров отсутствует");
        }

        return [
            'price' => Yii::$app->params['prices'][$type][$month][$tonnage],
            'price_list' => [
                $type => Yii::$app->params['prices'][$type]
            ]
        ];
    }
}
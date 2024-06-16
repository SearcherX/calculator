<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class HistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
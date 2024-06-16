<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class HistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin']
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

    public function actionView($id)
    {
        $model = History::findOne($id);
        $owner_id = $model->user->id;

        if (Yii::$app->user->can('viewHistory', ['owner_id' => $owner_id])) {
            return $this->renderAjax('view', ['model' => $model]);
        }

        throw new ForbiddenHttpException('Нет доступа');
    }

    public function actionDelete($id)
    {
        History::findOne($id)->delete();
        return $this->redirect('index');
    }

}
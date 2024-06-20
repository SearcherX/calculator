<?php

namespace app\controllers;

use app\models\History;
use app\models\HistorySearch;
use app\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class HistoryController extends Controller
{
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
        $ownerId = $model->user->id;

        if (Yii::$app->user->can('viewHistory', ['owner_id' => $ownerId])) {

            $dataProvider = new ArrayDataProvider([
                'allModels' => $model->getPrices(),
                'pagination' => false
            ]);

            return $this->renderAjax('view', ['model' => $model, 'dataProvider' => $dataProvider]);
        }

        throw new ForbiddenHttpException('Нет доступа');
    }

    public function actionDelete($id)
    {
        History::findOne($id)->delete();
        return $this->redirect('index');
    }

}
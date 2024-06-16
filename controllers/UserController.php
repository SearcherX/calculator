<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success-login', Yii::$app->user->identity->firstName, false);
            return $this->redirect('/calculator');
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                return $this->redirect(['/user/login']);
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionSignupValidation()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return;
    }

}
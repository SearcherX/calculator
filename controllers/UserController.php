<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success-login', Yii::$app->user->identity->username, false);
            return $this->redirect('/calculator');
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/calculator');
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return null;
    }

    public function actionProfile($id)
    {
        if (Yii::$app->user->can('viewProfile', ['owner_id' => $id])) {
            $model = User::findIdentity($id);
            return $this->render('profile', ['model' => $model]);
        }
        throw new ForbiddenHttpException('Нет доступа');

    }

}
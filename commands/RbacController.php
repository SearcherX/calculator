<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('user');
        $user->description = 'пользователь';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'администратор';
        $auth->add($admin);

        $viewUser = $auth->createPermission('viewUsers');
        $viewUser->description = 'Смотреть информацию о пользователях';
        $auth->add($viewUser);

        $auth->addChild($admin, $viewUser);

        $auth->addChild($admin, $user);

        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }

}
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
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $readHistory = $auth->createPermission('readHistory');
        $readHistory->description = 'Read history of calculations';
        $auth->add($readHistory);

        $auth->addChild($admin, $readHistory);
        $auth->addChild($user, $readHistory);

        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }

}
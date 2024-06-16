<?php

namespace app\commands;

use app\rules\IsOwnerRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //правила
        $ownerRule = new IsOwnerRule();
        $auth->add($ownerRule);

        //роли
        $user = $auth->createRole('user');
        $user->description = 'пользователь';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'администратор';
        $auth->add($admin);

        //разрешения
        $viewUser = $auth->createPermission('viewProfile');
        $viewUser->description = 'Смотреть информацию о пользователе';
        $auth->add($viewUser);

        $viewHistory = $auth->createPermission('viewHistory');
        $viewHistory->description = 'Смотреть информацию об истории рассчета';
        $auth->add($viewHistory);

        $viewOwnHistory = $auth->createPermission('viewOwnHistory');
        $viewOwnHistory->ruleName = $ownerRule->name;
        $auth->add($viewOwnHistory);

        //наделение ролей правами
        $auth->addChild($user, $viewOwnHistory);

        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $viewHistory);

        //наследование прав (иерархия)
        $auth->addChild($admin, $user);
        $auth->addChild($viewOwnHistory, $viewHistory);

        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }

}
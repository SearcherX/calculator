<?php

namespace app\commands;

use app\rules\IsOwnerRule;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\rbac\Role;

class RbacController extends Controller
{
    private function addRoutesToRole(array $routes, Role $role): void
    {
        $auth = Yii::$app->authManager;

        foreach ($routes as $route) {
            $permission = $auth->createPermission($route);
            $auth->add($permission);
            $auth->addChild($role, $permission);
        }
    }

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
        $viewProfile = $auth->createPermission('viewProfile');
        $viewProfile->description = 'Смотреть информацию о пользователе';
        $auth->add($viewProfile);

        $viewOwnProfile = $auth->createPermission('viewOwnProfile');
        $viewOwnProfile->ruleName = $ownerRule->name;
        $auth->add($viewOwnProfile);

        $viewHistory = $auth->createPermission('viewHistory');
        $viewHistory->description = 'Смотреть информацию об истории рассчета';
        $auth->add($viewHistory);

        $viewOwnHistory = $auth->createPermission('viewOwnHistory');
        $viewOwnHistory->ruleName = $ownerRule->name;
        $auth->add($viewOwnHistory);

        //наделение ролей правами
        $auth->addChild($user, $viewOwnHistory);
        $auth->addChild($user, $viewOwnProfile);

        $auth->addChild($admin, $viewProfile);
        $auth->addChild($admin, $viewHistory);

        //наследование прав (иерархия)
        $auth->addChild($admin, $user);
        $auth->addChild($viewOwnHistory, $viewHistory);
        $auth->addChild($viewOwnProfile, $viewProfile);

        $userRoutes = [
            '/user/logout',
            '/user/profile',
            '/history/index',
            '/history/view'
        ];

        $this->addRoutesToRole($userRoutes, $user);
        $this->addRoutesToRole(['/*'], $admin);

        $auth->assign($user, 2);
        $auth->assign($admin, 1);

        return ExitCode::OK;
    }

}
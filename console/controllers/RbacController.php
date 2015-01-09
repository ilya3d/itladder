<?php
namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller {

    public function actionInit() {

        $user = User::findOne(['username'=>'adm']);

        if (!$user){
            $user = new User();

            $user->id = 1;
            $user->login = 'adm';
            $user->email = 'max@twinscom.ru';
            $user->setPassword('123456');
            $user->generateAuthKey();

            $user->username = "Админ";
            $user->status = User::STATUS_ACTIVE;
            $user->role = User::ROLE_ADMIN;
            $user->save();
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        //Добавляем роли
        $user = $auth->createRole('user');
        $moder = $auth->createRole('moder');
        $admin = $auth->createRole('admin');

        //Создадим для примера права для доступа к админке
        $index  = $auth->createPermission('user.index');
        $view   = $auth->createPermission('user.view');
        $update   = $auth->createPermission('user.update');

        $dashboard = $auth->createPermission('dashboad');


        $auth->add($index);
        $auth->add($view);
        $auth->add($update);
        $auth->add($dashboard);

        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);

        $user->ruleName = $rule->name;
        $moder->ruleName = $rule->name;
        $admin->ruleName = $rule->name;

        $auth->add($user);
        $auth->add($moder);
        $auth->add($admin);

        //Добавляем потомков
        $auth->addChild($moder, $user);

        $auth->addChild($admin, $moder);

        $auth->addChild($admin, $index);
        $auth->addChild($admin, $view);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $dashboard);
    }
}
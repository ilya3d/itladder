<?php
namespace common\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * обработчик для правил доступа
 * Класс UserRoleRule отвечает за проверку равенства роли текущего юзера, роли прописанной в массиве разрешений.
 * Этим мы избегаем проблемы с назначением роли юзеру по его ID.
 * взят от сюда http://rgblog.ru/page/yii2-i-rbac-kontrol-dostupa-na-osnove-rolej
 * Class UserRoleRule
 * @package common\components\rbac
 */
class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));

        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === 'moder') {
                //moder является потомком admin, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER;
            }
            elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER
                || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}
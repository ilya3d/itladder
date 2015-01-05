<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\NotFoundHttpException;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $username =  \Yii::$app->request->getQueryParam('user');
        $user = User::findByUsername($username);

        if (!$user) throw new NotFoundHttpException('Not found user');

        return $this->render('index',['user'=>$user]);
    }

}

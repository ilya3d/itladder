<?php

namespace frontend\controllers;

use common\models\User;

class MailerController extends \yii\web\Controller
{
    public function actionIndex()
    {


        $users = User::find()->all();

        return $this->render(
            'index',
            [
                'users' => $users
            ]
        );
    }

}

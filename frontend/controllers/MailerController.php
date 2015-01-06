<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\MailerForm;
use Yii;

class MailerController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $model = new MailerForm();

        if ( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

            if ( $model->sendEmail( Yii::$app->params['adminEmail'] ) ) {
                //Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                //Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();

        } else {

            $users = User::find()->all();

            return $this->render(
                'index',
                [
                    'users' => $users,
                    'model' => $model,
                ]
            );

        }

    }

}

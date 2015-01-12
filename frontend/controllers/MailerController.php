<?php

namespace frontend\controllers;

use frontend\models\MailerForm;
use Yii;

class MailerController extends DashboardController
{
    public function actionIndex()
    {

        $model = new MailerForm();

        if ( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

            if ( $model->sendEmail( Yii::$app->params['adminEmail'] ) ) {
                Yii::$app->session->setFlash('success', 'Message sent successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();

        } else {

            return $this->render(
                'index',
                [
                    'model' => $model,
                ]
            );

        }

    }

}

<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class DashboardController extends Controller{

    public function beforeAction($action){
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('dashboad')) {

                //\Yii::$app->response->redirect('/site/login');
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }
}
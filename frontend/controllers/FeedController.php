<?php

namespace frontend\controllers;

class FeedController extends DashboardController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

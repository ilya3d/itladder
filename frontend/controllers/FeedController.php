<?php

namespace frontend\controllers;

use common\models\Feed;
use yii\web\Controller;

class FeedController extends Controller
{
    public function actionIndex()
    {

        return $this->render( 'index', [
                'list' => Feed::page()
            ]
        );
    }

}

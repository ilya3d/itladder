<?php

namespace frontend\controllers;

use common\models\Feed;
use frontend\models\AddFeedForm;
use Yii;
use yii\web\Controller;


class FeedController extends Controller
{
    public function actionIndex()
    {

        $model = new AddFeedForm();

        // todo права доступа


        if ( $model->load( Yii::$app->request->getBodyParams() ) && $model->validate() ) {

            Feed::add( $model->title, $model->text, $model->user_id );

            return $this->refresh();

        } else {

            return $this->render( 'index', [
                    'list' => Feed::page(),
                    'model' => $model,
                ]
            );

        }


    }

}

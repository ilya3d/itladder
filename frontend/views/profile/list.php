<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $list common\models\User[] */

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? foreach( $list as $title => $users): ?>
        <h2><?=$title?></h2><hr>
        <div class="blog-index">
        <? foreach( $users as $user): ?>
            <div class="row" style="margin-top: 10px; ">
                <div class="col-md-2"><?=Html::img(  $user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$user->photo  : '//placehold.it/64', ['style'=>'height: 64px;'] );?></div>
                <div class="col-md-4"><?=$user->username?></div>
                <div class="col-md-2"><?=$user->login?></div>
                <div class="col-md-2"><?=$user->email?></div>
                <div class="col-md-2"><?=$user->title_position?></div>
            </div>
        <? endforeach ?>
        </div>
    <? endforeach ?>

</div>

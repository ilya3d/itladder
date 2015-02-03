<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $list common\models\User[] */

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? foreach( $list as $title => $users): ?>
        <h2><?=$title?></h2><hr>
        <div class="row">
        <? foreach( $users as $user): ?>
            <div class="col-md-4" style="margin-top: 10px; ">
                <div class="col-md-4">
                    <?= Html::a(
                        Html::img(  $user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$user->photo  : '//placehold.it/64', ['style'=>'height: 64px;'] ),
                        '/profile/' . $user->login
                    )?>
                </div>
                <div class="col-md-8">
                    <strong><?=$user->username?></strong><br>
                    <?=$user->title_position?><br>
                    <?=$user->email?>
                </div>
            </div>
        <? endforeach ?>
        </div>
    <? endforeach ?>

</div>

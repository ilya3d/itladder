<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $commentForm \frontend\models\CommentForm */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
    <div class="row">
        <div class="col-md-9">
            <h1 style="margin-top: 10px;"><?= $model->title ?></h1>
        </div>
        <div class="col-md-3 text-right" style="margin-top: 10px; ">
            <? if (\Yii::$app->user->can('updateOwnProfile', ['profileId' => $model->user_id])): ?>
            <?= Html::a('edit','/blog/'.$model->user->login.'/'.$model->id.'/update',['class' => 'btn btn-success'])?>
            <?= Html::a('delete','/blog/'.$model->user->login.'/'.$model->id.'/delete',['class' => 'btn btn-danger','data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ]])?>
            <? endif ?>
        </div>
    </div>
    <div class="row" style="background-color: #F5F5F5; padding: 10px 30px 10px 30px;margin-bottom: 30px; border: 1px dotted;" >
        <div class="col-md-12">
            <?= $model->text ?>
        </div>
        <div><?= Html::a('back','/blog/'.$model->user->login)?></div>
    </div>
    <? if ($model->comments):?>
    <div class="row">
        <h3>Comments</h3>
    </div>
    <? endif ?>
    <? foreach($model->comments as $comment): ?>
    <div class="row" style="padding: 10px 30px 10px 0; margin-bottom: 10px; border: 1px dotted;">
        <div class="col-md-1 text-left">
            <img src="//placehold.it/64">
        </div>
        <div class="col-md-11 text-left">
            <p style="font-weight: bold"><?= $comment->user->login ?></p>
            <?= Html::decode($comment->text) ?>
        </div>
    </div>
    <? endforeach ?>
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <div class="col-md-12">
            <?php \yii\widgets\Pjax::begin(['options' => ['class' => 'pjax-wraper']]); ?>
            <?= $form->field($commentForm, 'text')->textarea() ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
        <div class="col-md-4 text-left">
            <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'name' => 'send-button', 'data-pjax' => '0']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

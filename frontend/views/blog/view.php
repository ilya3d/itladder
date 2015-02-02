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
    <div>
        <?= \frontend\widgets\CommentList::widget(['post'=>$model]); ?>
    </div>
</div>

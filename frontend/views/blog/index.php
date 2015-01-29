<?php

use common\models\Post;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = 'Blog';
?>
<div class="blog-index">
    <? if (Yii::$app->getUser()->getIdentity()->login === Yii::$app->getRequest()->get('user')): ?>
    <div class="row" style="margin-bottom: 20px;">
        <?= Html::a('Create post','/blog/'.Yii::$app->getUser()->getIdentity()->login.'/create',['class' => 'btn btn-success'])?>
    </div>
    <? endif ?>
    <? if (!$dataProvider->count):?>
    <div class="row">
        Not found
    </div>
    <? endif ?>

    <? foreach($dataProvider->getModels() as $item): ?>
    <?    /** @var Post $item */ ?>
    <div class="row" style="background-color: #F5F5F5; padding: 10px 30px 20px 30px;margin-bottom: 30px; border: 1px dotted;" >
        <div class="row">
            <div class="col-md-9">
                <h2 style="margin-top: 10px;"><?= $item->title ?></h2>
            </div>
            <? if (\Yii::$app->user->can('updateOwnProfile', ['profileId' => $item->user_id])): ?>
            <div class="col-md-3 text-right" style="margin-top: 10px;">
                <?= Html::a('edit','/blog/'.$item->user->login.'/'.$item->id.'/update',['class' => 'btn btn-success'])?>
            </div>
            <? endif ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $item->announce ?>
            </div>
        </div>
        <div class="row">
            <div><?= Html::a('readmore','/blog/'.$item->user->login.'/'.$item->id)?></div>
        </div>
    </div>
    <? endforeach ?>
</div>
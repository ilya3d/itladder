<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Add resource', ['rules', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Up position', ['uppos', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'login',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            'icq',
            'skype',
            'phone',
            'address',
            'title_position',
            [
                'label'=>'Group',
                'value'=>($model->group)?$model->group->name:''
            ],
            [
                'label'=>'Profession',
                'value'=> ($model->profession)?$model->profession->name:''
            ],
            [
                'label'=>'Birthday',
                'value'=>  Yii::$app->getFormatter()->asDatetime($model->birthday, 'php:d.m.Y')
            ],
            [
                'label'=>'Current Position',
                'value'=>($model->getCurrentPosition())?$model->getCurrentPosition()->stage->name:'',
            ],
            [
                'label'=>'Photo',
                'format' => 'html',
                'value' => ($model->photo)?Html::img(Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$model->photo,['class'=>'b-stamp']):Html::img('//placehold.it/200')
            ]
            //'status',
            //'created_at',
            //'register_at',
            //'updated_at',
        ],
    ]) ?>


    <? if ($model->resource2user):?>
        <h4>Resources:</h4>
        <div class="grid-view">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th></th>
                </tr>
                <? foreach($model->resource2user as $res2user): ?>
                    <tr>
                        <td><?= $res2user->resource->name ?></td>
                        <td><?= $res2user->value ?></td>
                        <td>
                            <? echo Html::a( Html::tag('i','',['class'=>'glyphicon glyphicon-edit']) , ['user/edit-rules?data='.$model->id.':'.$res2user->user_id.":".$res2user->resource_id]); ?>
                        </td>
                    </tr>
                <? endforeach ?>
            </table>
        </div>
    <? endif ?>

    <? if ($model->position2user):?>
        <h4>Positions:</h4>
        <div class="grid-view">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Date change</th>
                </tr>
                <? foreach($model->position2user as $pos2user): ?>
                    <tr class="<? if($pos2user->status==2):?>success<? elseif($pos2user->status==1):?>info<? endif;?>">
                        <td><?= $pos2user->position->stage->name ?></td>
                        <td>
                            <?= $pos2user->date_change ? Yii::$app->getFormatter()->asDatetime($pos2user->date_change, 'php:d.m.Y') : '' ?>
                            <? if($pos2user->status==0):?>at progress<? elseif($pos2user->status==1):?>collected<? endif;?>
                        </td>
                        <td>
                            <? echo Html::a( Html::tag('i','',['class'=>'glyphicon glyphicon-edit']) , ['user/edit-position?data='.$model->id.':'.$pos2user->position_id]); ?>
                        </td>
                    </tr>
                <? endforeach ?>
            </table>
        </div>
    <? endif ?>


</div>

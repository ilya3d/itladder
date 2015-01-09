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
        <?= Html::a('Add rules', ['rules', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
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
                'value'=>$model->getCurrentPosition()->stage->name,
            ],
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
<!--                            --><?// echo Html::a('edit', ['position/remove_rules'],[
//                                'id' => "a:".$res2user->position_id.":".$res2user->resource_id,
//                                'position_id' => $res2user->position_id,
//                                'resource_id' => $res2user->resource_id
//                            ]  );
//
//                            $this->registerJs("$('#a:{$res2user->position_id}:{$res2user->resource_id}').click();", \yii\web\View::POS_READY);
//
//                            ?>

                            <a href="#"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="/"><i class="glyphicon glyphicon-remove"></i></a>
                        </td>
                    </tr>
                <? endforeach ?>
            </table>
        </div>
    <? endif ?>

</div>

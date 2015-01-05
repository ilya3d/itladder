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
                'label'=>'Profession',
                'value'=> $model->profession->name
            ],
            [
                'label'=>'Birthday',
                'value'=>  Yii::$app->getFormatter()->asDatetime($model->birthday, 'php:d.m.Y')
            ],
            [
                'label'=>'Current Position',
                'value'=>$model->getCurrentPosition()->stage->name,
            ],
            [
                'label'=>'Next Position',
                'value'=>$model->getCurrentPosition()->stage->name,
            ],
            'status',
            'created_at',
            'register_at',
            'updated_at',
        ],
    ]) ?>

</div>

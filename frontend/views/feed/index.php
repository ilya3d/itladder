<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $list \common\models\Feed[]w */
?>
<h1>Feed</h1>

<? if ( \Yii::$app->user->can('dashboad') ): ?>
<div class="row">

    <?php $form = ActiveForm::begin(['id' => 'add-feed-form']); ?>

    <div class="col-md-4">
        <?= $form->field($model, 'title') ?>
    </div>

    <div class="col-md-4">
        <?= $form->field( $model, 'user_id', [ 'options' => ['class'=>'ca-grid__item'] ] )
            ->label( 'User' )
            ->dropDownList( \common\models\User::getList( true ) )
        ?>
    </div>

    <div class="col-md-4 text-right">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'name' => 'send-button']) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'text')->textArea(['rows' => 6]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<? endif; ?>

<? foreach( $list as $msg):?>
    <div class="row" style="background-color: #F5F5F5;margin-bottom: 30px; border: 1px dotted;">
        <div class="col-md-2">
            <?= $msg->date ?>
        </div>
        <div class="col-md-10">
            <?= $msg->text ?>
        </div>
    </div>
<? endforeach ?>
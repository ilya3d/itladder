<?php
use frontend\widgets\UserList;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 */
?>

<div class="container">

    <h1>Mailer</h1>

    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>


        <div class="col-md-4">
            <?= $form->field($model, 'subject') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'name' => 'send-button', 'data-pjax' => '0']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
        </div>


        <div class="col-md-12">
            <?php \yii\widgets\Pjax::begin(['options' => ['class' => 'pjax-wraper']]); ?>
            <?= $form->field($model, 'users')->widget(UserList::className(), []) ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>
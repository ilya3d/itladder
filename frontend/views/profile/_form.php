<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grid-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'skype')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'icq')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model,'birthday')->widget(DatePicker::className(),[
        'clientOptions' => [
            'defaultDate' => '2014-01-01',
            'changeYear'=>true,
            'changeMonth'=>true,
            'yearRange'=> '1960:2000'
        ],
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyyy'
    ]) ?>

    <?= $form->field($model, 'file')->label('photo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

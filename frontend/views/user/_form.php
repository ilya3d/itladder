<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'icq')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'skype')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'title_position')->textInput(['maxlength' => 255]) ?>

    <? $form->field($model, 'file')->label('photo')->fileInput() ?>

    <?= $form->field($model,'birthday')
            ->widget(DatePicker::className(),[
                'clientOptions' => [
                    'defaultDate' => '1980-01-01',
                    'changeYear'=>true,
                    'changeMonth'=>true,
                    'yearRange'=> '1960:2005',
                    //'altFormat' => 'dd.mm.yyyy'
                ],
                'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd'
            ])
    // @todo http://stackoverflow.com/questions/4392097/altformat-not-working-in-jquery-datepicker-input-field
    ?>

    <?= $form->field($model, 'profession_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Profession::find()->all(),'id','name') ) ?>

    <?= $form->field($model, 'group_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Group::find()->all(),'id','name') ) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\User::statusList()) ?>

    <?= (!$model->grid_id) ? $form->field($model, 'grid_id')->dropDownList( \yii\helpers\ArrayHelper::map( \common\models\Grid::find()->all(), 'id', 'name' ) ) : ''?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

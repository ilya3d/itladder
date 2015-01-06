<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Position
/* @var Resource2position $res2pos
*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($res2pos, 'resource_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Resource::find()->all(),'id','name') ) ?>
    <?= $form->field($res2pos, 'value')->textInput() ?>
    <?= $form->field($res2pos, 'position_id')->label('')->hiddenInput(['value'=>$model->id]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <? //\frontend\widgets\RulesEditor::widget(); ?>



</div>

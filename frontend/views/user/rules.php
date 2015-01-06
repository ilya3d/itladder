<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Resource2user;

/* @var $this yii\web\View
 * @var $model common\models\user
 * @var Resource2user $res2user
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($res2user, 'resource_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Resource::find()->all(),'id','name') ) ?>
    <?= $form->field($res2user, 'value')->textInput() ?>
    <?= $form->field($res2user, 'user_id')->label('')->hiddenInput(['value'=>$model->id]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

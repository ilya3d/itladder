<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use common\models\User2position;

/* @var $this yii\web\View
 * @var $model common\models\user
 * @var User2position $user2pos
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user2pos, 'date_change')->widget(DatePicker::className(),[
        'clientOptions' => [
            'defaultDate' => '2014-01-01',
            'changeYear'=>true,
            'changeMonth'=>true,
            'yearRange'=> '1960:2000',
        ],
        'language' => 'ru',
        'dateFormat' => 'dd.MM.yyyy'
    ]) ?>
    <?= $form->field($user2pos, 'user_id')->label('')->hiddenInput(['value'=>$model->id]) ?>
    <?= $form->field($user2pos, 'position_id')->label('')->hiddenInput(['value'=>$user2pos->position_id]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
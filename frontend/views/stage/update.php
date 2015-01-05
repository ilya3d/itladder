<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Stage */

$this->title = 'Update Stage: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

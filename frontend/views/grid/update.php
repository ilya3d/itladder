<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Grid */

$this->title = 'Update Grid: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Grids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Stage */

$this->title = 'Create Stage';
$this->params['breadcrumbs'][] = ['label' => 'Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Update Post: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['blog/'.$model->user->login]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['blog/'.$model->user->login.'/'.$model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

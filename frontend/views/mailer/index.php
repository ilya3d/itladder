<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $users \common\models\User[]
 */
?>

<div class="container">

    <h1>Mailer</h1>

    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <div class="form-group">
            <div class="col-md-4">
                <?= $form->field($model, 'subject') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'email') ?>
            </div>
            <div class="col-md-4 text-right">
                <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'name' => 'send-button']) ?>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

        <hr>

    <!-- todo remove to widget -->
        <div class="row">
            <div class="col-md-4">
                <select class="form-control">
                    <option>GRID</option>
                    <option>2</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control">
                    <option>GROUP</option>
                    <option>2</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </div>
    <hr>
        <div class="row">

            <table class="table">
                <? foreach($users as $user): ?>
                <tr>
                    <td><input type="checkbox" name="checkUser<?= $user->id ?>" value="1" checked></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->title_position ?></td>
                    <td><?= $user->title_position ?></td>
                </tr>
                <? endforeach; ?>
            </table>

        </div>


</div>
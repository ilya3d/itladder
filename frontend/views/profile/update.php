<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 */
?>

<div class="container">

    <div class="row">
        <div class="col-md-9">
            <h1><?= $user->username ?></h1>
        </div>
    </div>

    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="<?= $user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$user->photo  : '//placehold.it/200' ?>" class="avatar img-circle" alt="avatar">
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        Group: <?= $user->group ? $user->group->name : '' ?>
                    </div>
                    <div class="col-md-4">
                        Position: <?= $user->title_position ?>
                    </div>
                    <div class="col-md-4">
                        Stage: <?= $user->getCurrentPosition() ? $user->getCurrentPosition()->stage->name : '' ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                Birthday: <?= Yii::$app->getFormatter()->asDatetime($user->birthday, 'php:d.m.Y') ?>
            </div>

            <h4>Contact Information</h4>

            <?= $this->render('_form', [
                'model' => $user,
            ]) ?>

        </div>

    </div>
</div>
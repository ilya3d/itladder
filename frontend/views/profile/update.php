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
                <img src="<?= $user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$user->photo  : '//placehold.it/200' ?>" class="avatar" alt="avatar" style="max-width: 256px; max-height: 256px;" >
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <?= Yii::t('app/profile','Group') ?>: <?= $user->group ? $user->group->name : '' ?>
                    </div>
                    <div class="col-md-4">
                        <?= Yii::t('app/profile','Position') ?>: <?= Yii::$app->getFormatter()->format($user->title_position,'text') ?> <?= $user->profession ? '('.$user->profession->name.')' : '' ?>
                    </div>
                    <div class="col-md-4">
                        <?= Yii::t('app/profile','Stage') ?>: <?= $user->getCurrentPosition() ? $user->getCurrentPosition()->stage->name : '' ?>
                    </div>
                </div>
            </div>

            <h4>Contact Information</h4>

            <?= $this->render('_form', [
                'model' => $user,
            ]) ?>

        </div>

    </div>
</div>
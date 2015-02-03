<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 * @var $positions \common\models\User2position
 * @var $resource \common\models\Resource2position
*/
use yii\helpers\Html;

$this->title = $user->username;

/* @todo check formater XSS  */
?>

<div class="container">

    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($user->username);?></h1>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a( Yii::t('app/profile','Blog'), [ 'blog/' . $user->login], ['class' => 'btn btn-warning'] ) ?>

            <? if (\Yii::$app->user->can('updateOwnProfile', ['profileId' => $user->id])): ?>
            <?= Html::a( Yii::t('app/profile','Edit'), [ 'profile/' . $user->login . '/edit'], ['class' => 'btn btn-success'] ) ?>
            <? endif ?>
        </div>
    </div>

    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="<?= $user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$user->photo  : '//placehold.it/200' ?>" class="avatar" alt="avatar" style="max-width: 256px; max-height: 256px;" >
            </div>
            <div class="personal-info">

                <hr>

                <div class="form-group">
                    <?= Yii::t('app/profile','Group') ?>: <?= $user->group ? $user->group->name : '' ?>
                </div>
                <div class="form-group">
                    <?= Yii::t('app/profile','Position') ?>: <?= Html::encode($user->title_position) ?> <?= $user->profession ? '('.$user->profession->name.')' : '' ?>
                </div>
                <div class="form-group">
                    <?= Yii::t('app/profile','Stage') ?>: <?= $user->getCurrentPosition() ? $user->getCurrentPosition()->stage->name : '' ?>

                </div>
                <div class="form-group">
                    <?= Yii::t('app/profile','Birthday') ?>: <?= Yii::$app->getFormatter()->asDatetime($user->birthday, 'php:d.m.Y') ?>
                </div>

                <h4><?= Yii::t('app/profile','Contact Information') ?></h4>

                <table class="table table-striped">
                    <tr>
                        <td><?= Yii::t('app/profile','E-mail') ?></td>
                        <td><?= Html::encode($user->email) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app/profile','Phone') ?></td>
                        <td><?= Html::encode($user->phone) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app/profile','Skype') ?></td>
                        <td><?= Html::encode($user->skype) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app/profile','ICQ') ?></td>
                        <td><?= Html::encode($user->icq) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app/profile','Address') ?></td>
                        <td><?= Html::encode($user->address) ?></td>
                    </tr>
                </table>

            </div>
        </div>

        <!-- edit form column -->


        <div class="col-md-9" role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#feed" aria-controls="feed" role="tab" data-toggle="tab"><?= Yii::t('app/profile','Feed') ?></a></li>
                <li role="presentation"><a href="#ladder" aria-controls="ladder" role="tab" data-toggle="tab"><?= Yii::t('app/profile','Position stage') ?></a></li>
                <li role="presentation" class="disabled"><a href="#skills" aria-controls="skills" role="tab" data-toggle="tab"><?= Yii::t('app/profile','Profession skill') ?></a></li>
                <li role="presentation" class="disabled"><a href="#other" aria-controls="other" role="tab" data-toggle="tab"><?= Yii::t('app/profile','Other') ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="ladder">

                    <div class="list-group">

                        <div class="list-group-item">

                            <p class="list-group-item-heading"><?= Yii::t('app/profile','Next position is ') ?> <strong><?= $user->getNextPosition() ? $user->getNextPosition()->stage->name : '' ?><strong></p>
                            <hr>

                            <? if ($resource && $user->grid_id): ?>
                                <? foreach($resource as $item): ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong><?= $item->resource->name ?></strong>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $item->resource2user ? $item->resource2user->value : 0 ?>" aria-valuemin="0" aria-valuemax="<?= $item->value ?>" style="width: <?= ($item->resource2user ? $item->resource2user->value : 0)*100/$item->value ?>%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <?= $item->resource2user ? $item->resource2user->value : 0 ?>/<?= $item->value ?>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            <? endif ?>
                        </div>

                        <? foreach($positions as $item): ?>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">
                                    <strong><?= $item->position->stage->name ?></strong>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?= Yii::$app->getFormatter()->asDatetime($item->date_change, 'php:d.m.Y') ?>
                                </div>
                            </div>
                        </div>
                        <? endforeach; ?>

                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="skills"></div>
                <div role="tabpanel" class="tab-pane active" id="feed"></div>
                <div role="tabpanel" class="tab-pane" id="other"></div>
            </div>

        </div>

    </div>
</div>
<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 * @var $positions \common\models\User2position
 * @var $resource \common\models\Resource2position
*/
use yii\helpers\Html;

/* @todo check formater XSS  */
?>

<div class="container">

    <div class="row">
        <div class="col-md-9">
            <h1><?= $user->username ?></h1>
        </div>
        <div class="col-md-3 text-right">
            <? if (\Yii::$app->user->can('updateOwnProfile', ['profileId' => $user->id])): ?>
            <?= Html::a('Edit', [ 'profile/' . $user->login . '/edit'], ['class' => 'btn btn-success']) ?>
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
            <div class="form-group">
                Birthday: <?= Yii::$app->getFormatter()->asDatetime($user->birthday, 'php:d.m.Y') ?>
            </div>

            <h4>Contact Information</h4>

            <table class="table table-striped">
                <tr>
                    <td>E-mail</td>
                    <td><?= Yii::$app->getFormatter()->format($user->email,'text') ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?= Yii::$app->getFormatter()->format($user->phone,'text') ?></td>
                </tr>
                <tr>
                    <td>Skype</td>
                    <td><?= Yii::$app->getFormatter()->format($user->skype,'text') ?></td>
                </tr>
                <tr>
                    <td>ICQ</td>
                    <td><?= Yii::$app->getFormatter()->format($user->icq,'text') ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><?= Yii::$app->getFormatter()->format($user->address,'text') ?></td>
                </tr>
            </table>

        </div>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#ladder" aria-controls="ladder" role="tab" data-toggle="tab">Position skill</a></li>
                <li role="presentation" class="disabled"><a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">Profession skill</a></li>
                <li role="presentation" class="disabled"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
                <li role="presentation" class="disabled"><a href="#other" aria-controls="other" role="tab" data-toggle="tab">Other</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="ladder">

                    <div class="list-group">

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

                        <div class="list-group-item">

                            <h4 class="list-group-item-heading"><?= $user->getNextPosition() ? $user->getNextPosition()->stage->name : '' ?></h4>
                            <hr>
                            <? if ($resource): ?>
                                <? foreach($resource as $item): ?>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <strong><?= $item->resource->name ?></strong>
                                        </div>
                                        <div class="col-md-9">
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

                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="skills"></div>
                <div role="tabpanel" class="tab-pane" id="events"></div>
                <div role="tabpanel" class="tab-pane" id="other"></div>
            </div>

        </div>

    </div>
</div>
<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 * @var $positions \common\models\User2position
 * @var $resource \common\models\Resource2position
*/
?>

<div class="container">
    <h1>Profile: <?= $user->username ?></h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="//placehold.it/200" class="avatar img-circle" alt="avatar">
            </div>
        </div>

        <!-- edit form column -->
        <div class="col-md-9 personal-info">

            <div class="row">
                <div class="col-md-9">
                    <h3><?= $user->username ?> (<?= $user->login ?>)</h3>
                </div>
                <div class="col-md-3 text-right">
                    <button type="button" class="btn btn-success">Edit</button>
                </div>
            </div>

            <div class="form-group">
                Birthday: <?= Yii::$app->getFormatter()->asDatetime($user->birthday, 'php:d.m.Y') ?>
            </div>
            <div class="form-group">
                Group: <?= $user->username ?>
            </div>
            <div class="form-group">
                Position: <?= $user->title_position ?> ( <?= $user->getCurrentPosition()->stage->name ?> )
            </div>

            <h4>Contact Information</h4>

            <table class="table table-striped">
                <tr>
                    <td>E-mail</td>
                    <td><?= $user->email ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?= $user->phone ?></td>
                </tr>
                <tr>
                    <td>Skype</td>
                    <td><?= $user->skype ?></td>
                </tr>
                <tr>
                    <td>ICQ</td>
                    <td><?= $user->icq ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><?= $user->address ?></td>
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

                            <h4 class="list-group-item-heading"><?= $user->getCurrentPosition()->stage->name ?></h4>
                            <hr>

                            <? foreach($resource as $item): ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <strong><?= $item->resource->name ?></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $item->resource2user->value ?>" aria-valuemin="0" aria-valuemax="<?= $item->value ?>" style="width: <?= $item->resource2user->value*100/$item->value ?>%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <?= $item->resource2user->value ?>/<?= $item->value ?>
                                    </div>
                                </div>
                            <? endforeach; ?>

                        </div>

                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="skills">.2..</div>
                <div role="tabpanel" class="tab-pane" id="events">.3..</div>
                <div role="tabpanel" class="tab-pane" id="other">.4..</div>
            </div>

        </div>

    </div>
</div>
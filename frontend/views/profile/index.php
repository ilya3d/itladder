<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 * @var $positions \common\models\User2position
*/
//var_dump($user->positions)
//var_dump($resource)
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

            <h3><?= $user->username ?> (<?= $user->login ?>)</h3>

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
                    <td>Phone</td>
                    <td><?= $user->phone ?></td>
                </tr>
                <tr>
                    <td>Skype</td>
                    <td><?= $user->skype ?></td>
                </tr>
            </table>

        </div>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Position skill</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profession skill</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Events</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Ather</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">

                    <div class="list-group">

                        <? foreach($positions as $item): ?>
                        <div class="list-group-item">
                            <strong><?= $item->position->stage->name ?></strong> | <?= Yii::$app->getFormatter()->asDatetime($item->date_change, 'php:d.m.Y') ?>
                        </div>
                        <? endforeach; ?>

                        <div class="list-group-item">

                            <h4 class="list-group-item-heading"><?= $user->getCurrentPosition()->stage->name ?></h4>

                            <div class="list-group">

                                <? foreach($resource as $item): ?>
                                    <div class="list-group-item">
                                        <?= $item->resource->name ?> (<?= $item->resource2user->value ?>/<?= $item->value ?>)
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $item->resource2user->value ?>" aria-valuemin="0" aria-valuemax="<?= $item->value ?>" style="width: <?= $item->resource2user->value*100/$item->value ?>%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                <? endforeach; ?>

                            </div>

                        </div>

                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="profile">.2..</div>
                <div role="tabpanel" class="tab-pane" id="messages">.3..</div>
                <div role="tabpanel" class="tab-pane" id="settings">.4..</div>
            </div>

        </div>

    </div>
</div>
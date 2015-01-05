<?php
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
*/
//var_dump($user)
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
                Position: <?= $user->title_position ?>
            </div>

            <h4>Contact Information</h4>

            <table class="table">
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
                <div role="tabpanel" class="tab-pane active" id="home">...</div>
                <div role="tabpanel" class="tab-pane" id="profile">...</div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">...</div>
            </div>

        </div>

    </div>
</div>
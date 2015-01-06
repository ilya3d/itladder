<?php
/**
 * @var $this yii\web\View
 * @var $users \common\models\User[]
 */
?>

<div class="container">

    <h1>Mailer</h1>

    <form class="form-horizontal">

        <div class="form-group">
            <div class="col-md-4">
                <label class="sr-only" for="inpTheme">Theme</label>
                <input type="text" class="form-control" id="inpTheme" placeholder="Enter theme">
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="inpFrom">From</label>
                <input type="email" class="form-control" id="inpFrom" placeholder="Enter from">
            </div>
            <div class="col-md-4 text-right">
                <button type="submit" class="btn btn-success">Send</button>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-12">
            <textarea class="form-control" rows="6"></textarea>
            </div>
        </div>
    </form>

        <hr>

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
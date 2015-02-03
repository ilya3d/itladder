<?php
/* @var $this yii\web\View */
/* @var $list \common\models\Feed[]w */
?>
<h1>Feed</h1>

<? foreach( $list as $msg):?>
    <div class="row" style="background-color: #F5F5F5;margin-bottom: 30px; border: 1px dotted;">
        <div class="col-md-2">
            <?= $msg->date ?>
        </div>
        <div class="col-md-10">
            <?= $msg->text ?>
        </div>
    </div>
<? endforeach ?>
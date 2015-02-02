<?php
/**
 * @var \common\models\Post $model
 * @var \frontend\models\CommentForm $commentForm
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
\dosamigos\ckeditor\CKEditorAsset::register($this);

?>
<?php

$js = <<<JS
    $("document").ready(function(){
            $(".pjax-comment").on("pjax:end", function() {
                $("#msg-comment").html("");
                $.pjax.reload();
            });
        });

JS;

$this->registerJs($js);
?>
<?php \yii\widgets\Pjax::begin(['options' => ['class' => 'pjax-comment']]); ?>
<?php $form = ActiveForm::begin(['id' => 'comment-form','options' => ['data-pjax' => true ]]); ?>
<? if ($model->comments):?>
    <div class="row">
        <h3><?= Yii::t('app/blog','Comments') ?></h3>
    </div>
<? endif ?>
<? foreach($model->comments as $comment): ?>
    <div id="div_comment_<?= $comment->id ?>" class="row" style="padding: 10px 30px 10px 0; margin-bottom: 10px; border: 1px dotted;">
        <div class="col-md-1 text-left">
            <?
            $avatar = $comment->user->photo ? Yii::getAlias('@web_uploads').DIRECTORY_SEPARATOR.$comment->user->photo  : '//placehold.it/64'
            ?>
            <img src="<?= $avatar ?>" style="max-width: 64px; max-height: 64px;">
        </div>
        <div class="col-md-11 text-left">
            <?= \frontend\widgets\CommentView::widget(['comment'=>$comment]) ?>
        </div>
    </div>
<? endforeach ?>
<? if (!Yii::$app->user->getIsGuest()): ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($commentForm, 'text')->textarea(['id'=>'msg-comment']) ?>
    </div>
    <div class="col-md-4 text-left">
        <?= Html::submitButton(Yii::t('app/blog','send'), ['class' => 'btn btn-success', 'name' => 'send-button', 'data-pjax' => '0']) ?>
    </div>
</div>
<? endif ?>
<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>
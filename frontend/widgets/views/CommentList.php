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

            $(".js_comment_editor").click( function(){
                var comment_id = $(this).attr('comment');
                var content = $('#comment_'+comment_id).text();
                var textarea = document.createElement('textarea');

                textarea.setAttribute('style','width:100%;');
                textarea.innerHTML = content;
                $('#comment_'+comment_id).html(textarea).focus();

                $(this).hide();
            });
        });

JS;

$this->registerJs($js);
?>
<?php \yii\widgets\Pjax::begin(['options' => ['class' => 'pjax-comment']]); ?>
<?php $form = ActiveForm::begin(['id' => 'comment-form','options' => ['data-pjax' => true ]]); ?>
<? if ($model->comments):?>
    <div class="row">
        <h3>Comments</h3>
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
            <div class="col-md-12">
                <div class="col-md-6 text-left">
                    <p style="font-weight: bold"><?= $comment->user->login ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <span style="font-size: 10px;">
                    <?= Yii::$app->getFormatter()->asDatetime($comment->created_at,'php:d-m-Y H:i:s')  ?>
                    </span>
                    <? if (Yii::$app->user->identity->getId() == $comment->user_id): ?>
                        <?= Html::a('[edit]','#',['class'=>'js_comment_editor','comment'=>$comment->id,'data-pjax'=>0]) ?>
                    <? endif ?>
                </div>
            </div>
            <div class="col-md-12">
                <div id="comment_<?= $comment->id ?>" class="js_in_text col-md-12"><?= Html::decode($comment->text) ?></div>
            </div>
        </div>

    </div>
<? endforeach ?>
<? if (!Yii::$app->user->getIsGuest()): ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($commentForm, 'text')->textarea(['id'=>'msg-comment']) ?>
    </div>
    <div class="col-md-4 text-left">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'name' => 'send-button', 'data-pjax' => '0']) ?>
    </div>
</div>
<? endif ?>
<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>
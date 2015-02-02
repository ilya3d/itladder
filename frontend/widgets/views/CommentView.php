<?php
    /**
     * @var \common\models\Comment $comment
     * @var yii\web\View $this
     */
use yii\helpers\Html;
$js = <<<JS
    $("document").ready(function(){
        $(".js_comment_editor").click( function(e){
            e.preventDefault();
            var comment_id = $(this).attr('comment');
            var content = $('#comment_'+comment_id).text();
            var textarea = document.createElement('textarea');

            textarea.setAttribute('style','width:100%;');
            textarea.setAttribute('id','js_textarea_comment_'+comment_id);
            textarea.innerHTML = content;
            $('#comment_'+comment_id).html(textarea).focus();
            $(this).hide();

            $(this).parents().find(".js_save_comment[comment="+comment_id+"]").show();
        });

        $(".js_save_comment").click( function(e){
            e.preventDefault();
            var comment_id = $(this).attr('comment');
            var val = $("#js_textarea_comment_"+comment_id).val();

            $.ajax({
                url: '/blog/edit-comment',
                data: {'comment_id': comment_id, 'val': val},
                type     :'POST',
                cache    : false,
                success: function(data) {
                    $('#comment_'+comment_id).text(data.text);
                    $('.js_comment_editor[comment='+comment_id+']').show();
                    $('.js_save_comment[comment='+comment_id+']').hide();
                }
            });
        });
    });

JS;

$this->registerJs($js);
?>
<div class="col-md-12">
    <div class="col-md-6 text-left">
        <p style="font-weight: bold">
            <?= Html::a($comment->user->username,'/profile/'.$comment->user->login,['data-pjax'=>0]) ?>
        </p>
    </div>
    <div class="col-md-6 text-right">
        <span style="font-size: 10px;">
        <?= Yii::$app->getFormatter()->asDatetime($comment->created_at,'php:d-m-Y H:i:s')  ?>
        </span>
        <? if (!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->getId() == $comment->user_id): ?>
            <?= Html::a(Yii::t('app/blog','edit'),'#',['class'=>'js_comment_editor','comment'=>$comment->id,'data-pjax'=>0]) ?>
        <? endif ?>
    </div>
</div>
<div class="col-md-12">
    <div id="comment_<?= $comment->id ?>" class="js_in_text col-md-12"><?= Html::encode($comment->text) ?></div>
</div>
<? if (!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->getId() == $comment->user_id): ?>
<div class="col-md-12">
    <a class="js_save_comment" comment="<?= $comment->id ?>" style="display: none;padding-left: 15px;" href="#"><?= Yii::t('app/blog','save')?></a>
</div>
<? endif ?>

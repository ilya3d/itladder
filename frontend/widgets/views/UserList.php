<?php
/**
 * @var $users \common\models\User[]
 * @var $grids \common\models\Grid[]
 * @var $groups \common\models\Group[]
 * @var $search string
 * @var $grid int
 * @var $group int
 * @var yii\web\View $this
 */

    $js = <<<JS
fn = function(){
    var self = this;
    var data = {
        grid: jQuery('select[name=grid]').val(),
        group: jQuery('select[name=group]').val(),
        search: jQuery('input[name=search]').val()
    };

    var pjax_id = $(self).closest('.pjax-wraper').attr('id');

    var url_param = '?grid='+data.grid+'&group='+data.group+'&search='+data.search;
    $.pjax.reload( '#' + pjax_id, { "url" : url_param } );

    return false;
};
jQuery('select[name=grid]').change( fn );
jQuery('select[name=group]').change( fn );
jQuery('input[name=search]').change( fn ).on("keyup keypress",function(e) {
  var code = e.keyCode || e.which;
  if (code  == 13) {
    e.preventDefault();
    return false;
  }
});
JS;

    $this->registerJs( $js );
?>

<hr>

    <div class="col-md-4">
        <select name="grid" class="form-control" data-pjax="0" disabled>
            <option value="0">ALL GRIDS</option>
            <? foreach($grids as $item): ?>
            <option value="<?= $item->id ?>" <? if($grid==$item->id):?>selected<? endif; ?>><?= $item->name ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <select name="group" class="form-control" data-pjax="0">
            <option value="0">ALL GROUPS</option>
            <? foreach($groups as $item): ?>
                <option value="<?= $item->id ?>" <? if($group==$item->id):?>selected<? endif; ?>><?= $item->name ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search" value="<?= $search ?>" data-pjax="0">
    </div>



<div class="col-md-12">
    <hr>
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
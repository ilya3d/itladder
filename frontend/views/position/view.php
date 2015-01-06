<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Position */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add rules', ['rules', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label'=>'Grid',
                'value'=>$model->grid->name
            ],
            [
                'label'=>'Stage',
                'value'=>$model->stage->name
            ],
            [
                'label'=>'Next position',
                'value'=>($model->next)?$model->next->stage->name:'none'
            ]
        ],
    ]) ?>

    <? if ($model->resources2position):?>
        <h4>Resources:</h4>
        <div class="grid-view">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th></th>
                </tr>
                <? foreach($model->resources2position as $res2pos): ?>
                    <tr>
                        <td><?= $res2pos->resource->name ?></td>
                        <td><?= $res2pos->value ?></td>
                        <td>
                            <? echo Html::a('edit', ['position/remove_rules'],[
                                'id' => "a:".$res2pos->position_id.":".$res2pos->resource_id,
                                'position_id' => $res2pos->position_id,
                                'resource_id' => $res2pos->resource_id
                            ]  );

                            //$js =


                            $this->registerJs("$('#a:{$res2pos->position_id}:{$res2pos->resource_id}').click();", \yii\web\View::POS_READY);

                            ?>



                            <a href="#"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="/"><i class="glyphicon glyphicon-remove"></i></a>
                        </td>
                    </tr>
                <? endforeach ?>
            </table>
        </div>
    <? endif ?>
</div>

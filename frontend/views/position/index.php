<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Position', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'grid_id',
            [
              'label'=>'Grid',
              'value'=>function($searchModel){
                  return $searchModel->grid->name;
              }
            ],
            [
                'label'=>'Stage',
                'value'=>function($searchModel){
                    return $searchModel->stage->name;
                }
            ],
            [
                'label'=>'Next',
                'value'=>function($searchModel){
                    if ($searchModel->next){
                        return $searchModel->next->stage->name;
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

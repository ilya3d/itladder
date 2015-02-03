<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $index, $widget, $grid) {

            if ( $model->status == User::STATUS_DISABLED ) {
                return ['class' => 'warning'];
            } elseif ( $model->role == User::ROLE_ADMIN || $model->role == User::ROLE_MODER ) {
                return [ 'class' => 'info' ];
            } elseif ( $model->status == User::STATUS_NEW ) {
                return ['class' => 'success'];
            }

            return [];
        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            [
                'attribute'=>'login',
                'label'=>'Login',
                'format' => 'html',
                'value'=>function($searchModel){
                    return Html::a($searchModel->login, \yii\helpers\Url::toRoute('profile/'.$searchModel->login) );
                }
            ],
             'email:email',
             'phone',
             'title_position',
            [
                'attribute'=>'status',
                'label'=>'Status',
                'value'=>function($searchModel){
                    $statusList = \common\models\User::statusList();
                    return (isset($statusList[$searchModel->status]))? $statusList[$searchModel->status]:'';
                },
                'filter'=>Html::activeDropDownList(
                    $searchModel,
                    'status',
                    \yii\helpers\ArrayHelper::merge(
                        [''=>'all'],
                        \common\models\User::statusList()
                    ),
                    ['class' => 'form-control']
                )
            ],
             //'status',
            // 'created_at',
            // 'register_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

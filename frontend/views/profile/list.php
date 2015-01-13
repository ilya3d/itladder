<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'username',
            [
                'label'=>'Username',
                'attribute'=>'username',
                'format' => 'html',
                'value'=>function($searchModel){
                    return Html::a($searchModel->username, \yii\helpers\Url::toRoute('profile/'.$searchModel->login) );
                }
            ],
            //'login',
            //'auth_key',
            //'password_hash',
            // 'password_reset_token',
            'email:email',
            //'icq',
            //'skype',
            //'phone',
            //'address',
            'title_position',
            // 'profession_id',
            // 'birthday',
            // 'status',
            // 'created_at',
            // 'register_at',
            // 'updated_at',

            [
                'label'=>'Group',
                'attribute'=>'group_id',
                //'format' => 'html',
                'value'=>function($searchModel){
                    return $searchModel->group_id ? $searchModel->group->name : '';
                    // Html::a($searchModel->group, \yii\helpers\Url::toRoute('profile/'.$searchModel->username) );
                },
                'filter'=>Html::activeDropDownList(
                    $searchModel,
                    'group_id',
                    \yii\helpers\ArrayHelper::merge(
                        [''=>'all'],
                        \yii\helpers\ArrayHelper::map(
                            \common\models\Group::find()->asArray()->all(),
                            'id',
                            'name'
                        )
                    ),
                    ['class' => 'form-control']
                )
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

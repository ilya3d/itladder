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
                'format' => 'html',
                'value'=>function($searchModel){
                    return $searchModel->group_id ? $searchModel->group->name : '';
                    // Html::a($searchModel->group, \yii\helpers\Url::toRoute('profile/'.$searchModel->username) );
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

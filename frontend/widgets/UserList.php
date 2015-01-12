<?php

namespace frontend\widgets;

use common\models\Grid;
use common\models\Group;
use common\models\User;
use Yii;
use yii\base\Widget;


class UserList extends Widget
{

    public $model;
    public $attribute;

    public $list;
    public $gridList;
    public $groupList;
    public $search;
    public $grid;
    public $group;

    public function init() {
        parent::init();

        $this->gridList = Grid::find()->all();
        $this->groupList = Group::find()->all();

    }

    public function run() {

        $this->grid = (int)Yii::$app->request->get( 'grid' );
        $this->group = (int)Yii::$app->request->get( 'group' );
        $this->search = Yii::$app->request->get( 'search' );

        $userSearch = User::find();

//        if ( $this->grid )
//            $userSearch->where( ['grid'=>$this->grid] );

        if ( $this->group )
            $userSearch->where( ['group_id'=>$this->group] );

        if ( $this->search )
            $userSearch->where( 'username like :name', [ 'name' => '%' . $this->search . '%'] );

        $this->list = $userSearch->all();

        return $this->render( 'UserList', [
            'search' => $this->search,
            'grids' => $this->gridList,
            'groups' => $this->groupList,
            'users' => $this->list,
            'grid' => $this->grid,
            'group' => $this->group
        ] );
    }

}
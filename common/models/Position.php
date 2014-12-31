<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property integer $grid_id
 * @property integer $stage_id
 *
 * @property Stage $stage
 * @property Grid $grid
 * @property Resource[] $resources
 * @property User[] $users
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grid_id', 'stage_id'], 'required'],
            [['grid_id', 'stage_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grid_id' => 'Grid ID',
            'stage_id' => 'Stage ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrid()
    {
        return $this->hasOne(Grid::className(), ['id' => 'grid_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['id' => 'resource_id'])->viaTable('resource2position', ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this
            ->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user2position', ['position_id' => 'id'])
            ->where(['status'=>User2position::STATUS_COMPLETE])
            ;
    }

}

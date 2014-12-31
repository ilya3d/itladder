<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user2position".
 *
 * @property integer $user_id
 * @property integer $position_id
 * @property integer $date_change
 * @property integer $status
 *
 * @property User $user
 * @property Position $position
 */
class User2position extends \yii\db\ActiveRecord
{

    const STATUS_IN_PROGRESS = 0;
    const STATUS_COLLECTED = 1;
    const STATUS_COMPLETE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user2position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'date_change', 'status'], 'required'],
            [['user_id', 'position_id', 'date_change', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'position_id' => 'Position ID',
            'date_change' => 'Date Change',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }
}

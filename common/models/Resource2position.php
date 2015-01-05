<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resource2position".
 *
 * @property integer $resource_id
 * @property integer $position_id
 * @property integer $value
 *
 * @property Position $position
 * @property Resource $resource
 */
class Resource2position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resource2position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resource_id', 'position_id', 'value'], 'required'],
            [['resource_id', 'position_id', 'value'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'resource_id' => 'Resource ID',
            'position_id' => 'Position ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource2user()
    {
        return $this->hasOne(Resource2user::className(), ['resource_id' => 'resource_id']);
    }
}

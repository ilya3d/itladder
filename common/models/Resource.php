<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resource".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Resource2position[] $resource2positions
 * @property Resource2user[] $resource2users
 */
class Resource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource2positions()
    {
        return $this->hasMany(Resource2position::className(), ['resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource2users()
    {
        return $this->hasMany(Resource2user::className(), ['resource_id' => 'id']);
    }
}

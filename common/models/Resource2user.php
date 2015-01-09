<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resource2user".
 *
 * @property integer $resource_id
 * @property integer $user_id
 * @property integer $value
 *
 * @property Resource $resource
 * @property User $user
 */
class Resource2user extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resource2user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resource_id', 'user_id', 'value'], 'required'],
            [['resource_id', 'user_id', 'value'], 'integer'],
            ['resource_id', function($attribute, $params){
                $res2user = Resource2user::findOne(['resource_id'=>$this->resource_id,'user_id'=>$this->user]);
                if ( $res2user ) {
                    $this->addError($attribute, 'параметр уже задан');
                }
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'resource_id' => 'Resource ID',
            'user_id' => 'User ID',
            'value' => 'Value',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

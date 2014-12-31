<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grid".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Position[] $positions
 */
class Grid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grid';
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
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['grid_id' => 'id']);
    }
}

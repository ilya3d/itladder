<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feed".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $auth_id
 * @property integer $grid_id
 * @property integer $profession_id
 * @property string $title
 * @property string $text
 * @property string $value
 * @property string $link
 * @property string $date
 * @property integer $type
 * @property integer $level
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'auth_id', 'title', 'text', 'value', 'link', 'type', 'level'], 'required'],
            [['user_id', 'auth_id', 'grid_id', 'profession_id', 'type', 'level'], 'integer'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['title', 'value', 'link'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'auth_id' => 'Auth ID',
            'grid_id' => 'Grid ID',
            'profession_id' => 'Profession ID',
            'title' => 'Title',
            'text' => 'Text',
            'value' => 'Value',
            'link' => 'Link',
            'date' => 'Date',
            'type' => 'Type',
            'level' => 'Level',
        ];
    }

    public static function forUser( $id ) {

        return self::find()->where( [ 'user_id' => $id ] )->all();
    }

    public static function page() {

        return self::find()->orderBy( ['date'=>SORT_DESC] )->limit(20)->all();
    }
}

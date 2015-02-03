<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $adm_id
 * @property integer $grid_id
 * @property integer $profession_id
 * @property string $object
 * @property integer $res_id
 * @property string $data
 * @property string $text
 * @property string $value
 * @property string $link
 * @property string $date
 * @property integer $type
 * @property integer $level
 */
class Log extends ActiveRecord
{

    /** service data, which will not be shown in feed */
    const LEVEL_LOG = 0;

    /** data, for showing in feed */
    const LEVEL_INFO = 1;

    /** type not provided */
    const TYPE_NONE = 0;

    /** information data */
    const TYPE_INFO = 1;

    /** reach stage level */
    const TYPE_STAGE = 2;

    /** receive achievement */
    const TYPE_ACHIEVEMENT = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_id', 'adm_id', 'grid_id', 'profession_id', 'object', 'res_id', 'data', 'text', 'value', 'link', 'type', 'level'], 'required'],
            [['user_id', 'adm_id', 'grid_id', 'profession_id', 'res_id', 'type', 'level'], 'integer'],
            [['data', 'text'], 'string'],
            [['date'], 'safe'],

            ['level', 'default', 'value' => self::LEVEL_LOG],
            ['level', 'in', 'range' => [self::LEVEL_LOG, self::LEVEL_INFO]],

            ['type', 'default', 'value' => self::TYPE_NONE],
            ['type', 'in', 'range' => [self::TYPE_NONE, self::TYPE_INFO, self::TYPE_STAGE, self::TYPE_ACHIEVEMENT]],

            [['object', 'value', 'link'], 'string', 'max' => 255]
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
            'adm_id' => 'Adm ID',
            'grid_id' => 'Grid ID',
            'profession_id' => 'Profession ID',
            'object' => 'Object',
            'res_id' => 'Res ID',
            'data' => 'Data',
            'text' => 'Text',
            'value' => 'Value',
            'link' => 'Link',
            'date' => 'Date',
            'type' => 'Type',
            'level' => 'Level',
        ];
    }

    /**
     * Record for resource update for user
     * @param User $user
     * @param Resource $res
     * @param string $val
     * @param string $text
     */
    public static function addResource( User $user, Resource $res, $val, $text='' )
    {
        $log = new Log();
        $log->user_id = $user->id;
        $log->res_id = $res->id;
        $log->value = $val;
        $log->text = $text;

        $log->adm_id = 0; // todo make if auto

        $log->save();
    }

    public static function addInfo( User $user, $text )
    {
        $log = new Log();
        $log->user_id = $user->id;
        $log->text = $text;

        $log->save();
    }

}

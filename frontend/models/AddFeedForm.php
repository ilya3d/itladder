<?php

namespace frontend\models;

use yii\base\Model;


class AddFeedForm extends Model {


    public $title;
    public $text;

    public $user_id;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','text'], 'required'],
            [['user_id'], 'integer']
            //['email', 'email'],
        ];
    }


}
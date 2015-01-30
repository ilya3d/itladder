<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * CommentForm is the model behind the contact form.
 */
class CommentForm extends Model
{
    public $text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['text'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Comment',
        ];
    }

}

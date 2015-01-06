<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class MailerForm extends Model
{

    public $email;
    public $subject;
    public $body;
    public $sendList;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'body','sendList'], 'required'],
            ['email', 'email'],
        ];
    }


    /**
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail( $email )
    {
        // todo list mailer
        return Yii::$app->mailer->compose()
            ->setTo( $email )
            ->setFrom( [$this->email => $this->email] )
            ->setSubject( $this->subject )
            ->setTextBody( $this->body )
            ->send();
    }

}
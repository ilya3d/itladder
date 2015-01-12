<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;


class MailerForm extends Model
{

    public $email;
    public $subject;
    public $body;
    public $users;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'body'], 'required'],
            ['email', 'email'],
        ];
    }


    /**
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail( $email )
    {
        $userList = [];
        $mailList = [];
        foreach ( Yii::$app->request->post() as $key=>$val ) {
            if ( ( strpos( $key, 'checkUser' ) === 0 ) && $val ) {
                $userList[] = (int)substr( $key, 9 );
            }
        }

        // todo ->each
        $users = User::findAll( ['id' => $userList] );
        foreach ( $users as $user )
            if ( $user->email )
                $mailList[] = $user->email;

        // todo list mailer
        return Yii::$app->mailer->compose()
            ->setTo( $mailList )
            ->setFrom( [$this->email => $this->email] )
            ->setSubject( $this->subject )
            ->setTextBody( $this->body )
            ->send();
    }

}
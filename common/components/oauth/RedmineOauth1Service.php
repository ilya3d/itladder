<?php

namespace common\components\oauth;

use OAuth\OAuth1\Token\TokenInterface;
use nodge\eauth\oauth1\Service;

class RedmineOauth1Service extends Service
{

    protected $name = 'redmine';
    protected $title = 'Redmine';
    protected $type = 'OAuth1';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

    protected $providerOptions = array(
        'request' => 'http://redmine.vv90.ru/oauth/request_token',
        'authorize' => 'http://redmine.vv90.ru/oauth/authorize',
        'access' => 'http://redmine.vv90.ru/oauth/access_token',
    );
    protected $baseApiUrl = 'http://redmine.vv90.ru/';
    protected $tokenDefaultLifetime = TokenInterface::EOL_NEVER_EXPIRES;

    /**
     * @return bool
     */
    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('oauth/user_info')['user'];

        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = $info['lastname']." ".$info['firstname'];
        $this->attributes['email'] = $info['mail'];
        $this->attributes['login'] = $info['login'];

        return true;
    }

    /**
     * Authenticate the user.
     *
     * @return boolean whether user was successfuly authenticated.
     */
    public function authenticate()
    {
        if (isset($_GET['denied'])) {
            $this->cancel();
        }

        return parent::authenticate();
    }

}
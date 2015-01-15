<?php
namespace common\models;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;
use nodge\eauth\services\VKontakteOAuth2Service;
use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\imagine\Image;
use yii\web\IdentityInterface;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $login
 * @property string $icq
 * @property string $skype
 * @property string $phone
 * @property string $address
 * @property string $title_position
 * @property string $birthday
 * @property integer $redmine_id
 *
 * @property integer $grid_id
 * @property integer $group_id
 *
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 *
 * @property string photo
 *
 * @property integer $register_at
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Profession $profession
 * @property Group $group
 * @property Position[] $positions
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static $users;

    const STATUS_ACTIVE = 10;
    const STATUS_DISABLED = 5;
    const STATUS_NEW = 1;

    const ROLE_USER = 1;
    const ROLE_MODER = 5;
    const ROLE_ADMIN = 10;

    public $file;

    /**
     * @var array EAuth attributes
     */
    public $profile;

    public static function statusList(){
        return [
            self::STATUS_DISABLED => 'disabled',
            self::STATUS_ACTIVE => 'active',
            self::STATUS_NEW => 'new',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['username','login','icq','skype','phone','address','title_position','email','birthday'], 'string'],
            [['profession_id','group_id','grid_id'], 'integer'],
            ['birthday','default','value'=>Yii::$app->formatter->asDate('now -20 year')],

            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ACTIVE, self::STATUS_NEW]],
            ['file','file','extensions' => ['png', 'jpg', 'gif', 'jpeg'],'mimeTypes'=>'image/jpeg, image/png, image/gif','maxSize' => 1024*1024*1024],

            ['birthday',function(){
                if ($this->birthday)
                    $this->birthday = Yii::$app->getFormatter()->asDate($this->birthday,'php:Y-m-d');
            }],


        ];
    }

    public function afterSave($insert, $changedAttributes) {

        $position = $this->getPositions()->one();
        if (!$position && $this->grid_id){

            /** @var Position $pos */
            $pos = Position::find()
                ->where(['grid_id'=>$this->grid_id])
                ->orderBy(['stage_id'=>'ASC']) // todo its wrong sort
                ->limit(1)
                ->one();

            if ($pos) {
                $curPos = new User2position();
                $curPos->user_id = $this->id;
                $curPos->position_id = $pos->id;
                $curPos->status = User2position::STATUS_COMPLETE;
                $curPos->date_change = time();
                $curPos->save();

                $curPos = new User2position();
                $curPos->user_id = $this->id;
                $curPos->position_id = $pos->next_position;
                $curPos->status = User2position::STATUS_IN_PROGRESS;
                $curPos->date_change = 0;
                $curPos->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }


    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE,self::STATUS_NEW]]);
    }

    /*
    public static function findIdentity($id) {
        if (Yii::$app->getSession()->has('user-'.$id)) {
            return new self(Yii::$app->getSession()->get('user-'.$id));
        }
        else {
            return isset(self::$users[$id]) ? new self(self::$users[$id]) : static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }
    */


    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName().'-'.$service->getId();

        if ($service->getServiceName()=='vkontakte'){
            $attributes = array(
                'id' => $id,
                'login' => $service->getAttribute('username'),
                'username' => $service->getAttribute('name'),
                'auth_key' => md5($id),
                'profile' => $service->getAttributes(),
            );
        } else {
            $attributes = array(
                'id' => $id,
                'login' => $service->getAttribute('name'),
                'username' => $service->getAttribute('name'),
                'auth_key' => md5($id),
                'profile' => $service->getAttributes(),
            );
        }

        $attributes['profile']['service'] = $service->getServiceName();

        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login, 'status' => [self::STATUS_ACTIVE,self::STATUS_NEW]]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['id' => 'position_id'])->viaTable('user2position', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getCurrentPosition()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user2position', ['position_id' => 'id'])->andWhere(['user2position.status'=>User2position::STATUS_COMPLETE])->orderBy('user2position.date_change');
    }
    */

    /**
     * @return Position static
     */
    public function getCurrentPosition()
    {
        /** @var User2position $user2pos */
        $user2pos =  User2position::find()
            ->where(['user_id'=>$this->id,'status'=>User2position::STATUS_COMPLETE])
            ->orderBy(['date_change'=>SORT_DESC])
            ->limit(1)
            ->one();
        return $user2pos ? Position::findOne(['id'=>$user2pos->position_id]) : false;


    }

    /**
     * @return Position static
     */
    public function getNextPosition()
    {
        /** @var User2position $user2pos */
        $user2pos = User2position::find()
            ->where( ['user_id'=>$this->id, 'status'=>[User2position::STATUS_IN_PROGRESS,User2position::STATUS_COLLECTED] ] )
            ->orderBy(['date_change'=>'ASC'])
            ->limit(1)
            ->one();
        return $user2pos ? Position::findOne(['id'=>$user2pos->position_id]) : false;


    }

    public function getProfession(){
        return $this->hasOne(Profession::className(), ['id'=>'profession_id']);
    }

    public function getGroup(){
        return $this->hasOne(Group::className(), ['id'=>'group_id']);
    }


    public function getResource2user()
    {
        return $this->hasMany(Resource2user::className(), ['user_id' => 'id']);
    }


    public function getPosition2user()
    {
        return $this->hasMany(User2position::className(), ['user_id' => 'id']);
    }

    public function beforeSave($insert) {

        $file = UploadedFile::getInstance($this,'file');

        if ($file){

            $dir = Yii::getAlias('@uploads');
            if (!is_dir($dir)){
                mkdir($dir, 0755, true);
            }

            $ext = end(explode(".", $file->name));

            $filename =  Yii::$app->security->generateRandomString('20') . ".{$ext}";
            try {

                $imagine = new Imagine();
                $mode = ImageInterface::THUMBNAIL_INSET;
                $size    = new Box(256, 256);

                $imagine->open($file->tempName)->thumbnail($size, $mode)->save($dir . '/' . $filename);

                //$file->saveAs($dir . '/' . $filename);
                $this->photo = $filename;
            } catch(\Exception $e) {
                new ServerErrorHttpException("Не удалось сохранить файл");
            }
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function checkPositionStatus()
    {

        $user = $this;

        // todo remove to User2Position model
        if ( $this->getCurrentPosition() ) {

            $userNextPosition = $this->getCurrentPosition()->next_position;

            $resource = Resource2position::find()
                ->with( ['resource',
                    'resource2user' => function ($query) use ($user) {
                        /** @var Query $query */
                        $query->andWhere( ['user_id' => $user->id] );
                    }
                ] )
                ->with( 'resource2user' )
                ->where(['position_id'=>$userNextPosition])
                ->all();

            $bReady = true;
            foreach ( $resource as $item ) {

                if ( !$item->resource2user ) {
                    $bReady = false;
                    break;
                }

                if ( $item->resource2user->value < $item->value ) {
                    $bReady = false;
                    break;
                }

            }

            if ( $bReady ) {
                $user2pos =  User2position::findOne(['user_id'=>$this->id,'status'=>User2position::STATUS_IN_PROGRESS]);
                $user2pos->status = User2position::STATUS_COLLECTED;
                $r = $user2pos->save();
            }
        }

    }

}

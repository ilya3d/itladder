<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
 * @property integer $birthday
 *
 * @property string $email
 * @property string $auth_key
 * @property integer $status
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
    public $grid;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NEW = 1;

    const ROLE_USER = 1;
    const ROLE_MODER = 5;
    const ROLE_ADMIN = 10;

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
            [['username','login','icq','skype','phone','address','title_position','email'], 'string'],
            [['profession_id','group_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ACTIVE, self::STATUS_NEW]],
        ];
    }

    public function load($data, $formName = null) {

        // @todo разобратся как правильно грузить модельку
        if (isset($data['profession_id']))
            $this->setAttribute('profession',Profession::findOne(['id'=>$data['profession_id']]));

        $formName = ($formName === null) ? $this->formName() : $formName;
        if (isset($data[$formName]['birthday']) && $data[$formName]['birthday']!='')
            $this->birthday = \DateTime::createFromFormat('d.m.Y',$data[$formName]['birthday'])->format('U');

        return parent::load($data, $formName); // TODO: Change the autogenerated stub
    }


    public function afterSave($insert, $changedAttributes) {

        if ( $this->grid ) {

            /** @var Position $pos */
            $pos = Position::find()
                ->where(['grid_id'=>$this->grid])
                ->orderBy(['stage_id'=>'ASC']) // todo its wrong sort
                ->limit(1)
                ->one();

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

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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
        return static::findOne(['login' => $login, 'status' => self::STATUS_ACTIVE]);
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
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user2position', ['position_id' => 'id']);
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
            ->orderBy(['date_change'=>'ASC'])
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

}

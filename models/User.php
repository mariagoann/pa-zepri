<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\helpers\Security;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property int $UserID
 * @property string $username
 * @property string $password
 * @property string $role
 *
 * @property Personalinfo[] $personalinfos
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserID', 'username', 'password'], 'required'],
            [['UserID'], 'integer'],
            [['role'], 'string'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 225],
            [['UserID'], 'unique'],
            [['username', 'auth_key'], 'string', 'max' => 50],
            [['password', 'password_reset_token'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserID' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
        ];
    }

    /**
     * Gets query for [[Personalinfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonalinfos()
    {
        return $this->hasMany(Personalinfo::className(), ['UserID' => 'UserID']);
    }

    public static function getUser($username){
        return new static (User::find()->where(['username' => $username])->one());
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
 
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}

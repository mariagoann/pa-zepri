<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personalinfo".
 *
 * @property int $PersonalID
 * @property string $FullName
 * @property int $IdentityType
 * @property string $IdentityNumber
 * @property string $IdentityExpiryDate
 * @property string $PlaceOfBirth
 * @property string $DateOfBirth
 * @property int $Status
 * @property int $Gender
 * @property int $Religion
 * @property string $PhoneNumber
 * @property string $Address
 * @property string $Email
 * @property int|null $UserID
 *
 * @property Employment[] $employments
 * @property Identitytype $identityType
 * @property Gender $gender
 * @property Religion $religion
 * @property User $user
 * @property Statuspersonal $status
 */
class Personalinfo extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personalinfo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FullName', 'IdentityType', 'IdentityNumber', 'IdentityExpiryDate', 'PlaceOfBirth', 'DateOfBirth', 'Status', 'Gender', 'Religion', 'PhoneNumber', 'Address', 'Email'], 'required'],
            [['IdentityType', 'Status', 'Gender', 'Religion', 'UserID'], 'integer'],
            [['IdentityExpiryDate', 'DateOfBirth'], 'safe'],
            [['FullName', 'Email'], 'string', 'max' => 150],
            [['IdentityNumber', 'PhoneNumber'], 'string', 'max' => 15],
            [['PlaceOfBirth'], 'string', 'max' => 50],
            [['Address'], 'string', 'max' => 225],
            [['IdentityType'], 'exist', 'skipOnError' => true, 'targetClass' => Identitytype::className(), 'targetAttribute' => ['IdentityType' => 'IdentityTypeID']],
            [['Gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['Gender' => 'GenderID']],
            [['Religion'], 'exist', 'skipOnError' => true, 'targetClass' => Religion::className(), 'targetAttribute' => ['Religion' => 'ReligionID']],
            [['UserID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['UserID' => 'UserID']],
            [['Status'], 'exist', 'skipOnError' => true, 'targetClass' => Statuspersonal::className(), 'targetAttribute' => ['Status' => 'StatusPersonalID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PersonalID' => 'Personal ID',
            'FullName' => 'Full Name',
            'IdentityType' => 'Identity Type',
            'IdentityNumber' => 'Identity Number',
            'IdentityExpiryDate' => 'Identity Expiry Date',
            'PlaceOfBirth' => 'Place Of Birth',
            'DateOfBirth' => 'Date Of Birth',
            'Status' => 'Status',
            'Gender' => 'Gender',
            'Religion' => 'Religion',
            'PhoneNumber' => 'Phone Number',
            'Address' => 'Address',
            'Email' => 'Email',
            'UserID' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasOne(Employment::className(), ['PersonalID' => 'PersonalID']);
    }

    /**
     * Gets query for [[IdentityType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdentityType()
    {
        return $this->hasOne(Identitytype::className(), ['IdentityTypeID' => 'IdentityType']);
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['GenderID' => 'Gender']);
    }

    /**
     * Gets query for [[Religion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReligion()
    {
        return $this->hasOne(Religion::className(), ['ReligionID' => 'Religion']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['UserID' => 'UserID']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuspersonal::className(), ['StatusPersonalID' => 'Status']);
    }
}

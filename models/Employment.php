<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employment".
 *
 * @property int $EmployeeID
 * @property int $PersonalID
 * @property string $JoinDate
 * @property int $EmployeeStatus
 * @property int $OrganizationID
 * @property int $JobPositionID
 * @property string|null $AKA_JobPosition
 * @property int|null $JobTitleID
 * @property int|null $LevelID
 * @property int|null $EmployeeSuperiorID
 * @property int|null $SquadID
 * @property string|null $EmployeeNumber
 *
 * @property Personalinfo $personal
 * @property Employment $employeeSuperior
 * @property Employment[] $employments
 * @property Employeestatus $employeeStatus
 * @property Organization $organization
 * @property Jobposition $jobPosition
 * @property Jobtitle $jobTitle
 * @property Joblevel $level
 * @property Squad $squad
 * @property Pacomponent[] $pacomponents
 * @property Paparameter[] $paparameters
 * @property Performanceappraisal[] $performanceappraisals
 * @property Performanceappraisal[] $performanceappraisals0
 * @property Performanceappraisal[] $performanceappraisals1
 * @property Performanceappraisal[] $performanceappraisals2
 * @property Performanceappraisal[] $performanceappraisals3
 * @property Performanceappraisal[] $performanceappraisals4
 * @property Performanceappraisal[] $performanceappraisals5
 */
class Employment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PersonalID', 'JoinDate', 'EmployeeStatus', 'OrganizationID', 'JobPositionID'], 'required'],
            [['PersonalID', 'EmployeeStatus', 'OrganizationID', 'JobPositionID', 'JobTitleID', 'LevelID', 'EmployeeSuperiorID', 'SquadID'], 'integer'],
            [['JoinDate'], 'safe'],
            [['AKA_JobPosition'], 'string', 'max' => 150],
            [['EmployeeNumber'], 'string', 'max' => 20],
            [['PersonalID'], 'exist', 'skipOnError' => true, 'targetClass' => Personalinfo::className(), 'targetAttribute' => ['PersonalID' => 'PersonalID']],
            [['EmployeeSuperiorID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['EmployeeSuperiorID' => 'EmployeeID']],
            [['EmployeeStatus'], 'exist', 'skipOnError' => true, 'targetClass' => Employeestatus::className(), 'targetAttribute' => ['EmployeeStatus' => 'EmployeeStatusID']],
            [['OrganizationID'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['OrganizationID' => 'OrganizationID']],
            [['JobPositionID'], 'exist', 'skipOnError' => true, 'targetClass' => Jobposition::className(), 'targetAttribute' => ['JobPositionID' => 'JobPositionID']],
            [['JobTitleID'], 'exist', 'skipOnError' => true, 'targetClass' => Jobtitle::className(), 'targetAttribute' => ['JobTitleID' => 'JobTitleID']],
            [['LevelID'], 'exist', 'skipOnError' => true, 'targetClass' => Joblevel::className(), 'targetAttribute' => ['LevelID' => 'LevelID']],
            [['SquadID'], 'exist', 'skipOnError' => true, 'targetClass' => Squad::className(), 'targetAttribute' => ['SquadID' => 'SquadID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EmployeeID' => 'Employee ID',
            'PersonalID' => 'Personal ID',
            'JoinDate' => 'Join Date',
            'EmployeeStatus' => 'Employee Status',
            'OrganizationID' => 'Organization ID',
            'JobPositionID' => 'Job Position ID',
            'AKA_JobPosition' => 'Aka Job Position',
            'JobTitleID' => 'Job Title ID',
            'LevelID' => 'Level ID',
            'EmployeeSuperiorID' => 'Employee Superior ID',
            'SquadID' => 'Squad ID',
            'EmployeeNumber' => 'Employee Number',
        ];
    }

    /**
     * Gets query for [[Personal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonal()
    {
        return $this->hasOne(Personalinfo::className(), ['PersonalID' => 'PersonalID']);
    }

    /**
     * Gets query for [[EmployeeSuperior]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSuperior()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'EmployeeSuperiorID']);
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['EmployeeSuperiorID' => 'EmployeeID']);
    }

    /**
     * Gets query for [[EmployeeStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeStatus()
    {
        return $this->hasOne(Employeestatus::className(), ['EmployeeStatusID' => 'EmployeeStatus']);
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['OrganizationID' => 'OrganizationID']);
    }

    /**
     * Gets query for [[JobPosition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobPosition()
    {
        return $this->hasOne(Jobposition::className(), ['JobPositionID' => 'JobPositionID']);
    }

    /**
     * Gets query for [[JobTitle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobTitle()
    {
        return $this->hasOne(Jobtitle::className(), ['JobTitleID' => 'JobTitleID']);
    }

    /**
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Joblevel::className(), ['LevelID' => 'LevelID']);
    }

    /**
     * Gets query for [[Squad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSquad()
    {
        return $this->hasOne(Squad::className(), ['SquadID' => 'SquadID']);
    }

    /**
     * Gets query for [[Pacomponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPacomponents()
    {
        return $this->hasMany(Pacomponent::className(), ['EmployeementID' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Paparameters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaparameters()
    {
        return $this->hasMany(Paparameter::className(), ['ReviewByID' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals()
    {
        return $this->hasMany(Performanceappraisal::className(), ['EmployeeID' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals0()
    {
        return $this->hasMany(Performanceappraisal::className(), ['PeersID1' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals1()
    {
        return $this->hasMany(Performanceappraisal::className(), ['PeersID2' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals2()
    {
        return $this->hasMany(Performanceappraisal::className(), ['SuperiorID1' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals3]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals3()
    {
        return $this->hasMany(Performanceappraisal::className(), ['SuperiorID2' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals4]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals4()
    {
        return $this->hasMany(Performanceappraisal::className(), ['SubordinateID1' => 'EmployeeID']);
    }

    /**
     * Gets query for [[Performanceappraisals5]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals5()
    {
        return $this->hasMany(Performanceappraisal::className(), ['SubordinateID2' => 'EmployeeID']);
    }
}

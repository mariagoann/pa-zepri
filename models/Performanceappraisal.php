<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "performanceappraisal".
 *
 * @property int $PerformanceAppraisalID
 * @property int $EmployeeID
 * @property int|null $PeersID1
 * @property int|null $PeersID2
 * @property int|null $SuperiorID1
 * @property int|null $SuperiorID2
 * @property int|null $SubordinateID1
 * @property int|null $SubordinateID2
 * @property int|null $PeriodeID
 * @property string|null $Status
 *
 * @property Pacomponent[] $pacomponents
 * @property Paparameter[] $paparameters
 * @property Employment $employee
 * @property Employment $peersID1
 * @property Employment $peersID2
 * @property Employment $superiorID1
 * @property Employment $superiorID2
 * @property Employment $subordinateID1
 * @property Employment $subordinateID2
 * @property Periode $periode
 */
class Performanceappraisal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'performanceappraisal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeeID'], 'required'],
            [['EmployeeID', 'PeersID1', 'PeersID2', 'SuperiorID1', 'SuperiorID2', 'SubordinateID1', 'SubordinateID2', 'PeriodeID'], 'integer'],
            [['Status'], 'string', 'max' => 50],
            [['EmployeeID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['EmployeeID' => 'EmployeeID']],
            [['PeersID1'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['PeersID1' => 'EmployeeID']],
            [['PeersID2'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['PeersID2' => 'EmployeeID']],
            [['SuperiorID1'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['SuperiorID1' => 'EmployeeID']],
            [['SuperiorID2'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['SuperiorID2' => 'EmployeeID']],
            [['SubordinateID1'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['SubordinateID1' => 'EmployeeID']],
            [['SubordinateID2'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['SubordinateID2' => 'EmployeeID']],
            [['PeriodeID'], 'exist', 'skipOnError' => true, 'targetClass' => Periode::className(), 'targetAttribute' => ['PeriodeID' => 'PeriodeID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PerformanceAppraisalID' => 'Performance Appraisal ID',
            'EmployeeID' => 'Employee ID',
            'PeersID1' => 'Peers Id1',
            'PeersID2' => 'Peers Id2',
            'SuperiorID1' => 'Superior Id1',
            'SuperiorID2' => 'Superior Id2',
            'SubordinateID1' => 'Subordinate Id1',
            'SubordinateID2' => 'Subordinate Id2',
            'PeriodeID' => 'Periode ID',
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Pacomponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPacomponents()
    {
        return $this->hasMany(Pacomponent::className(), ['PerformanceAppraisalID' => 'PerformanceAppraisalID']);
    }

    /**
     * Gets query for [[Paparameters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaparameters()
    {
        return $this->hasMany(Paparameter::className(), ['PerformanceAppraisalID' => 'PerformanceAppraisalID']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'EmployeeID']);
    }

    /**
     * Gets query for [[PeersID1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeersID1()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'PeersID1']);
    }

    /**
     * Gets query for [[PeersID2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeersID2()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'PeersID2']);
    }

    /**
     * Gets query for [[SuperiorID1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuperiorID1()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'SuperiorID1']);
    }

    /**
     * Gets query for [[SuperiorID2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuperiorID2()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'SuperiorID2']);
    }

    /**
     * Gets query for [[SubordinateID1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubordinateID1()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'SubordinateID1']);
    }

    /**
     * Gets query for [[SubordinateID2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubordinateID2()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'SubordinateID2']);
    }

    /**
     * Gets query for [[Periode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeriode()
    {
        return $this->hasOne(Periode::className(), ['PeriodeID' => 'PeriodeID']);
    }
}

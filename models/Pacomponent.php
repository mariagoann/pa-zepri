<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pacomponent".
 *
 * @property int $PAComponentID
 * @property int $PerformanceAppraisalID
 * @property float $Self
 * @property float $Peers
 * @property float $SubordinatesToSuperior
 * @property float $SuperiorToSubordinates
 * @property float $EmployeeScore
 * @property float|null $TotalScore
 * @property int $EmployeeID
 * @property int $PeriodeID
 * @property string|null $TrackRecord
 *
 * @property Performanceappraisal $performanceAppraisal
 * @property Employment $employee
 * @property Periode $periode
 */
class Pacomponent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pacomponent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PerformanceAppraisalID', 'Self', 'Peers', 'SubordinatesToSuperior', 'SuperiorToSubordinates', 'EmployeeScore', 'EmployeeID', 'PeriodeID'], 'required'],
            [['PerformanceAppraisalID', 'EmployeeID', 'PeriodeID'], 'integer'],
            [['Self', 'Peers', 'SubordinatesToSuperior', 'SuperiorToSubordinates', 'EmployeeScore', 'TotalScore'], 'number'],
            [['TrackRecord'], 'string', 'max' => 250],
            [['PerformanceAppraisalID'], 'exist', 'skipOnError' => true, 'targetClass' => Performanceappraisal::className(), 'targetAttribute' => ['PerformanceAppraisalID' => 'PerformanceAppraisalID']],
            [['EmployeeID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['EmployeeID' => 'EmployeeID']],
            [['PeriodeID'], 'exist', 'skipOnError' => true, 'targetClass' => Periode::className(), 'targetAttribute' => ['PeriodeID' => 'PeriodeID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PAComponentID' => 'Pa Component ID',
            'PerformanceAppraisalID' => 'Performance Appraisal ID',
            'Self' => 'Self',
            'Peers' => 'Peers',
            'SubordinatesToSuperior' => 'Subordinates To Superior',
            'SuperiorToSubordinates' => 'Superior To Subordinates',
            'EmployeeScore' => 'Employee Score',
            'TotalScore' => 'Total Score',
            'EmployeeID' => 'Employee ID',
            'PeriodeID' => 'Periode ID',
            'TrackRecord' => 'Track Record',
        ];
    }

    /**
     * Gets query for [[PerformanceAppraisal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceAppraisal()
    {
        return $this->hasOne(Performanceappraisal::className(), ['PerformanceAppraisalID' => 'PerformanceAppraisalID']);
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
     * Gets query for [[Periode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeriode()
    {
        return $this->hasOne(Periode::className(), ['PeriodeID' => 'PeriodeID']);
    }
}

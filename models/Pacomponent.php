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
 * @property float $SuperiorToSubOrdinates
 * @property int $EmployeeID
 * @property int $PeriodeID
 * @property float $Total
 * @property string $TrackRecord
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
            [['PerformanceAppraisalID', 'Self', 'Peers', 'SubordinatesToSuperior', 'SuperiorToSubOrdinates', 'EmployeeID', 'PeriodeID', 'Total', 'TrackRecord'], 'required'],
            [['PerformanceAppraisalID', 'EmployeeID', 'PeriodeID'], 'integer'],
            [['Self', 'Peers', 'SubordinatesToSuperior', 'SuperiorToSubOrdinates', 'Total'], 'number'],
            [['TrackRecord'], 'string', 'max' => 150],
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
            'SuperiorToSubOrdinates' => 'Superior To Sub Ordinates',
            'EmployeeID' => 'Employee ID',
            'PeriodeID' => 'Periode ID',
            'Total' => 'Total',
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

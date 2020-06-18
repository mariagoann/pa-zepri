<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pastatus".
 *
 * @property int $PaStatusID
 * @property int|null $PerformanceAppraisalID
 * @property int $EmployeeID
 * @property int $ReviewbyID
 * @property string|null $Type
 * @property int $PeriodeID
 * @property string $Status
 * @property string|null $EvaluateDate
 *
 * @property Employment $reviewby
 * @property Employment $employee
 * @property Performanceappraisal $performanceAppraisal
 */
class Pastatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pastatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PaStatusID', 'EmployeeID', 'ReviewbyID', 'PeriodeID'], 'required'],
            [['PaStatusID', 'PerformanceAppraisalID', 'EmployeeID', 'ReviewbyID', 'PeriodeID'], 'integer'],
            [['EvaluateDate'], 'safe'],
            [['Type'], 'string', 'max' => 50],
            [['Status'], 'string', 'max' => 1],
            [['PaStatusID'], 'unique'],
            [['ReviewbyID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['ReviewbyID' => 'EmployeeID']],
            [['EmployeeID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['EmployeeID' => 'EmployeeID']],
            [['PerformanceAppraisalID'], 'exist', 'skipOnError' => true, 'targetClass' => Performanceappraisal::className(), 'targetAttribute' => ['PerformanceAppraisalID' => 'PerformanceAppraisalID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PaStatusID' => 'Pa Status ID',
            'PerformanceAppraisalID' => 'Performance Appraisal ID',
            'EmployeeID' => 'Employee ID',
            'ReviewbyID' => 'Reviewby ID',
            'Type' => 'Type',
            'PeriodeID' => 'Periode ID',
            'Status' => 'Status',
            'EvaluateDate' => 'Evaluate Date',
        ];
    }

    /**
     * Gets query for [[Reviewby]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewby()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'ReviewbyID']);
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
     * Gets query for [[PerformanceAppraisal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceAppraisal()
    {
        return $this->hasOne(Performanceappraisal::className(), ['PerformanceAppraisalID' => 'PerformanceAppraisalID']);
    }
}

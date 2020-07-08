<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paparameter".
 *
 * @property int $PAParameterID
 * @property string|null $PositiveContribution
 * @property string|null $SelfImprovement
 * @property float $EmployeePerformanceScore
 * @property string $TeamImprovement
 * @property string $Aspirasi
 * @property float $AGILE
 * @property string $PositifSelfAgile
 * @property string $NegativeSelfAgile
 * @property float $IMPACT
 * @property string $PositiveSelfImpact
 * @property string $NegativeSelfImpact
 * @property float $UDPE
 * @property string $PositiveSelfUDPE
 * @property string $NegativeSelfUDPE
 * @property float $Entrepreneurial
 * @property string $PositiveSelfEntrepreneurial
 * @property string $NegativeSelfEntrepreneurial
 * @property float $OpenInnovation
 * @property string $PositiveSelfInnovation
 * @property string $NegativeSelfInnovation
 * @property float|null $AvgValues
 * @property string|null $TypePA
 * @property int $PerformanceAppraisalID
 * @property int $ReviewByID
 * @property string $Status
 *
 * @property Performanceappraisal $performanceAppraisal
 * @property Employment $reviewBy
 */
class Paparameter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paparameter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EmployeePerformanceScore', 'TeamImprovement', 'Aspirasi', 'AGILE', 'PositifSelfAgile', 'NegativeSelfAgile', 'IMPACT', 'PositiveSelfImpact', 'NegativeSelfImpact', 'UDPE', 'PositiveSelfUDPE', 'NegativeSelfUDPE', 'Entrepreneurial', 'PositiveSelfEntrepreneurial', 'NegativeSelfEntrepreneurial', 'OpenInnovation', 'PositiveSelfInnovation', 'NegativeSelfInnovation', 'PerformanceAppraisalID', 'ReviewByID', 'Status','PositiveContribution','SelfImprovement'], 'required'],
            [['EmployeePerformanceScore', 'AGILE', 'IMPACT', 'UDPE', 'Entrepreneurial', 'OpenInnovation', 'AvgValues'], 'number'],
            [['PerformanceAppraisalID', 'ReviewByID'], 'integer'],
            [['PositiveContribution', 'SelfImprovement', 'TeamImprovement', 'Aspirasi', 'PositifSelfAgile', 'NegativeSelfAgile', 'PositiveSelfImpact', 'NegativeSelfImpact', 'PositiveSelfUDPE', 'NegativeSelfUDPE', 'PositiveSelfEntrepreneurial', 'NegativeSelfEntrepreneurial', 'PositiveSelfInnovation', 'NegativeSelfInnovation'], 'string', 'max' => 250],
            [['TypePA', 'Status'], 'string', 'max' => 50],
            [['PerformanceAppraisalID'], 'exist', 'skipOnError' => true, 'targetClass' => Performanceappraisal::className(), 'targetAttribute' => ['PerformanceAppraisalID' => 'PerformanceAppraisalID']],
            [['ReviewByID'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['ReviewByID' => 'EmployeeID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PAParameterID' => 'Pa Parameter ID',
            'PositiveContribution' => 'Positive Contribution',
            'SelfImprovement' => 'Self Improvement',
            'EmployeePerformanceScore' => 'Employee Performance Score',
            'TeamImprovement' => 'Team Improvement',
            'Aspirasi' => 'Aspirasi',
            'AGILE' => 'Agile',
            'PositifSelfAgile' => 'Positif Self Agile',
            'NegativeSelfAgile' => 'Negative Self Agile',
            'IMPACT' => 'Impact',
            'PositiveSelfImpact' => 'Positive Self Impact',
            'NegativeSelfImpact' => 'Negative Self Impact',
            'UDPE' => 'Udpe',
            'PositiveSelfUDPE' => 'Positive Self Udpe',
            'NegativeSelfUDPE' => 'Negative Self Udpe',
            'Entrepreneurial' => 'Entrepreneurial',
            'PositiveSelfEntrepreneurial' => 'Positive Self Entrepreneurial',
            'NegativeSelfEntrepreneurial' => 'Negative Self Entrepreneurial',
            'OpenInnovation' => 'Open Innovation',
            'PositiveSelfInnovation' => 'Positive Self Innovation',
            'NegativeSelfInnovation' => 'Negative Self Innovation',
            'AvgValues' => 'Avg Values',
            'TypePA' => 'Type Pa',
            'PerformanceAppraisalID' => 'Performance Appraisal ID',
            'ReviewByID' => 'Review By ID',
            'Status' => 'Status',
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
     * Gets query for [[ReviewBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewBy()
    {
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'ReviewByID']);
    }
}

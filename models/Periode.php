<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periode".
 *
 * @property int $PeriodeID
 * @property string $Start
 * @property string $End
 * @property string $LastModified
 * @property string|null $Status
 *
 * @property Pacomponent[] $pacomponents
 * @property Performanceappraisal[] $performanceappraisals
 */
class Periode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Start', 'End', 'LastModified'], 'required'],
            [['Start', 'End', 'LastModified'], 'safe'],
            [['Status'], 'string', 'max' => 1],
            [['Start','End'],'validatedate']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PeriodeID' => 'Periode ID',
            'Start' => 'Start',
            'End' => 'End',
            'LastModified' => 'Last Modified',
            'Status' => 'Status',
        ];
    }

    public function validatedate(){
        $end_date = strtotime($this->End);
        $start_date = strtotime($this->Start);
        if (!$this->hasErrors() && $start_date > $end_date) {
            $this->addError('Start', 'Start must less than End');
            $this->addError('End', 'End must greater than Start');
        }
    }
    /**
     * Gets query for [[Pacomponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPacomponents()
    {
        return $this->hasMany(Pacomponent::className(), ['PeriodeID' => 'PeriodeID']);
    }

    /**
     * Gets query for [[Performanceappraisals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformanceappraisals()
    {
        return $this->hasMany(Performanceappraisal::className(), ['PeriodeID' => 'PeriodeID']);
    }
}

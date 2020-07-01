<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobposition".
 *
 * @property int $JobPositionID
 * @property string $CodeJobPosition
 * @property string $JobPositionName
 * @property int $Level
 *
 * @property Employment[] $employments
 */
class Jobposition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobposition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CodeJobPosition', 'JobPositionName', 'Level'], 'required'],
            [['Level'], 'integer'],
            [['CodeJobPosition'], 'string', 'max' => 150],
            [['JobPositionName'], 'string', 'max' => 50],
            [['CodeJobPosition'], 'unique'],
            [['JobPositionName'], 'unique'],
            [['Level'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JobPositionID' => 'Job Position ID',
            'CodeJobPosition' => 'ID Job Position',
            'JobPositionName' => 'Job Position Name',
            'Level' => 'Level',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['JobPositionID' => 'JobPositionID']);
    }
}

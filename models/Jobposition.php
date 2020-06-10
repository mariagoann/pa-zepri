<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobposition".
 *
 * @property int $JobPositionID
 * @property string|null $CodeJobPosition
 * @property string $JobPositionName
 * @property int $Level
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
            [['JobPositionName', 'Level'], 'required'],
            [['Level'], 'integer'],
            [['CodeJobPosition'], 'string', 'max' => 150],
            [['JobPositionName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JobPositionID' => 'Job Position ID',
            'CodeJobPosition' => 'Code Job Position',
            'JobPositionName' => 'Job Position Name',
            'Level' => 'Level',
        ];
    }
}

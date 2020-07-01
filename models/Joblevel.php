<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "joblevel".
 *
 * @property int $LevelID
 * @property string $CodeLevel
 * @property string $LevelName
 *
 * @property Employment[] $employments
 */
class Joblevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'joblevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CodeLevel', 'LevelName'], 'required'],
            [['CodeLevel'], 'string', 'max' => 150],
            [['LevelName'], 'string', 'max' => 50],
            [['CodeLevel'], 'unique'],
            [['LevelName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LevelID' => 'Level ID',
            'CodeLevel' => 'ID Level',
            'LevelName' => 'Level Name',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['LevelID' => 'LevelID']);
    }
}

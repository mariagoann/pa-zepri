<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobtitle".
 *
 * @property int $JobTitleID
 * @property string $CodeJobTitle
 * @property string $JobTitleName
 *
 * @property Employment[] $employments
 */
class Jobtitle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobtitle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CodeJobTitle', 'JobTitleName'], 'required'],
            [['CodeJobTitle'], 'string', 'max' => 150],
            [['JobTitleName'], 'string', 'max' => 50],
            [['CodeJobTitle'], 'unique'],
            [['JobTitleName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JobTitleID' => 'Job Title ID',
            'CodeJobTitle' => 'ID Job Title',
            'JobTitleName' => 'Job Title Name',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['JobTitleID' => 'JobTitleID']);
    }
}

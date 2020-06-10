<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employeestatus".
 *
 * @property int $EmployeeStatusID
 * @property string $Name
 *
 * @property Employment[] $employments
 */
class Employeestatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employeestatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'EmployeeStatusID' => 'Employee Status ID',
            'Name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['EmployeeStatus' => 'EmployeeStatusID']);
    }
}

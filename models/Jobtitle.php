<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobtitle".
 *
 * @property int $JobTitleID
 * @property string|null $CodeJobTitle
 * @property string $JobTitleName
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
            [['JobTitleName'], 'required'],
            [['CodeJobTitle'], 'string', 'max' => 150],
            [['JobTitleName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JobTitleID' => 'Job Title ID',
            'CodeJobTitle' => 'Code Job Title',
            'JobTitleName' => 'Job Title Name',
        ];
    }
}

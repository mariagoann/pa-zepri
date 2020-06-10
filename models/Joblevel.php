<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "joblevel".
 *
 * @property int $LevelID
 * @property string|null $CodeLevel
 * @property string|null $LevelName
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
            [['CodeLevel'], 'string', 'max' => 150],
            [['LevelName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LevelID' => 'Level ID',
            'CodeLevel' => 'Code Level',
            'LevelName' => 'Level Name',
        ];
    }
}

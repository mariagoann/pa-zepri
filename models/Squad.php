<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "squad".
 *
 * @property int $SquadID
 * @property string $CodeSquad
 * @property string $SquadName
 *
 * @property Employment[] $employments
 */
class Squad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'squad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CodeSquad', 'SquadName'], 'required'],
            [['CodeSquad'], 'string', 'max' => 150],
            [['SquadName'], 'string', 'max' => 50],
            [['SquadName'], 'unique'],
            [['CodeSquad'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SquadID' => 'Squad ID',
            'CodeSquad' => 'ID Squad',
            'SquadName' => 'Squad Name',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['SquadID' => 'SquadID']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "squad".
 *
 * @property int $SquadID
 * @property string|null $CodeSquad
 * @property string $SquadName
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
            [['SquadName'], 'required'],
            [['CodeSquad'], 'string', 'max' => 150],
            [['SquadName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SquadID' => 'Squad ID',
            'CodeSquad' => 'Code Squad',
            'SquadName' => 'Squad Name',
        ];
    }
}

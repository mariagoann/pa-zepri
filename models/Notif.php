<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notif".
 *
 * @property int $NotifID
 * @property int $PeriodeID
 * @property string|null $Message
 * @property string|null $Notes
 * @property int $Read
 * @property int|null $To
 * @property int|null $TypeTo
 * @property string|null $GoTo
 * @property string|null $Created_at
 */
class Notif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PeriodeID'], 'required'],
            [['PeriodeID', 'Read', 'To', 'TypeTo'], 'integer'],
            [['Created_at'], 'safe'],
            [['Message'], 'string', 'max' => 150],
            [['Notes'], 'string', 'max' => 250],
            [['GoTo'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NotifID' => 'Notif ID',
            'PeriodeID' => 'Periode ID',
            'Message' => 'Message',
            'Notes' => 'Notes',
            'Read' => 'Read',
            'To' => 'To',
            'TypeTo' => 'Type To',
            'GoTo' => 'Go To',
            'Created_at' => 'Created At',
        ];
    }
}

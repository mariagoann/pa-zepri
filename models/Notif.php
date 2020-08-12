<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notif".
 *
 * @property int $NotifID
 * @property string|null $Message
 * @property int $Read
 * @property int|null $To
 * @property int|null $TypeTo
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
            [['Read', 'To', 'TypeTo'], 'integer'],
            [['Created_at'], 'safe'],
            [['Message'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NotifID' => 'Notif ID',
            'Message' => 'Message',
            'Read' => 'Read',
            'To' => 'To',
            'TypeTo' => 'Type To',
            'Created_at' => 'Created At',
        ];
    }
}

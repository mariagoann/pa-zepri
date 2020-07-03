<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notif".
 *
 * @property int $NotifID
 * @property string $Message
 * @property string $Created_at
 * @property int $Read
 * @property int|null $To
 *
 * @property User $to
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
            [['NotifID', 'Message', 'Created_at'], 'required'],
            [['NotifID', 'Read', 'To'], 'integer'],
            [['Created_at'], 'safe'],
            [['Message'], 'string', 'max' => 255],
            [['NotifID'], 'unique'],
            [['To'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['To' => 'UserID']],
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
            'Created_at' => 'Created At',
            'Read' => 'Read',
            'To' => 'To',
        ];
    }

    /**
     * Gets query for [[To]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['UserID' => 'To']);
    }
}

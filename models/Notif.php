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
 * @property Employment $to
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
            [['Message', 'Created_at'], 'required'],
            [['Created_at'], 'safe'],
            [['Read', 'To'], 'integer'],
            [['Message'], 'string', 'max' => 255],
            [['To'], 'exist', 'skipOnError' => true, 'targetClass' => Employment::className(), 'targetAttribute' => ['To' => 'EmployeeID']],
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
        return $this->hasOne(Employment::className(), ['EmployeeID' => 'To']);
    }
}

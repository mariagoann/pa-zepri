<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "religion".
 *
 * @property int $ReligionID
 * @property string $Name
 *
 * @property Personalinfo[] $personalinfos
 */
class Religion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'religion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ReligionID', 'Name'], 'required'],
            [['ReligionID'], 'integer'],
            [['Name'], 'string', 'max' => 20],
            [['ReligionID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ReligionID' => 'Religion ID',
            'Name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Personalinfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonalinfos()
    {
        return $this->hasMany(Personalinfo::className(), ['Religion' => 'ReligionID']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gender".
 *
 * @property int $GenderID
 * @property string $Name
 *
 * @property Personalinfo[] $personalinfos
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GenderID', 'Name'], 'required'],
            [['GenderID'], 'integer'],
            [['Name'], 'string', 'max' => 10],
            [['GenderID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'GenderID' => 'Gender ID',
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
        return $this->hasMany(Personalinfo::className(), ['Gender' => 'GenderID']);
    }
}

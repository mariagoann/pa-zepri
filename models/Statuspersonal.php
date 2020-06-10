<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statuspersonal".
 *
 * @property int $StatusPersonalID
 * @property string $Name
 *
 * @property Personalinfo[] $personalinfos
 */
class Statuspersonal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuspersonal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StatusPersonalID', 'Name'], 'required'],
            [['StatusPersonalID'], 'integer'],
            [['Name'], 'string', 'max' => 20],
            [['StatusPersonalID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StatusPersonalID' => 'Status Personal ID',
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
        return $this->hasMany(Personalinfo::className(), ['Status' => 'StatusPersonalID']);
    }
}

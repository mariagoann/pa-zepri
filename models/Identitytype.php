<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "identitytype".
 *
 * @property int $IdentityTypeID
 * @property string $Name
 *
 * @property Personalinfo[] $personalinfos
 */
class Identitytype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'identitytype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdentityTypeID', 'Name'], 'required'],
            [['IdentityTypeID'], 'integer'],
            [['Name'], 'string', 'max' => 225],
            [['IdentityTypeID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdentityTypeID' => 'Identity Type ID',
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
        return $this->hasMany(Personalinfo::className(), ['IdentityType' => 'IdentityTypeID']);
    }
}

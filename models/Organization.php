<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $OrganizationID
 * @property string|null $CodeOrganization
 * @property string $OrganizationName
 *
 * @property Employment[] $employments
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrganizationName'], 'required'],
            [['CodeOrganization'], 'string', 'max' => 150],
            [['OrganizationName'], 'string', 'max' => 50],
            [['CodeOrganization'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationID' => 'Organization ID',
            'CodeOrganization' => 'ID Organization',
            'OrganizationName' => 'Organization Name',
        ];
    }

    /**
     * Gets query for [[Employments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['OrganizationID' => 'OrganizationID']);
    }
}

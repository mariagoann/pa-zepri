<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $OrganizationID
 * @property string|null $CodeOrganization
 * @property string $OrganizationName
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrganizationID' => 'Organization ID',
            'CodeOrganization' => 'Code Organization',
            'OrganizationName' => 'Organization Name',
        ];
    }
}

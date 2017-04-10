<?php

namespace app\models;

class OrganizationParent extends \yii\db\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'organization_parents';
    }
    
    public function rules()
    {
        return [
            [['organization_id', 'parent_id'], 'required'],
            [['organization_id', 'parent_id'], 'integer'],
        ];
    }
}

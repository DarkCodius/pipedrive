<?php

namespace app\models;

class Organization extends \yii\db\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'organizations';
    }
    
    public function rules()
    {
        return [
            [['organization_id'], 'integer'],
            [['organization_name'], 'required'],
            [['organization_name'], 'unique'],
        ];
    }
    
    public static function primaryKey()
    {
        return ['organization_id'];
    }
}
 

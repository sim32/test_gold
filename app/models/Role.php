<?php

namespace app\models;

use yii\db\ActiveRecord;

class Role extends ActiveRecord
{

    public static function tableName()
    {
        return '{{tbl_role}}';
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id' => 'id']);
    }
}
<?php

namespace app\forms\admin;

use yii\base\Model;


class EditForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $role_id;
    public $active;

    public function rules()
    {
        return [
            ['email', 'email'],
            [['email', 'name', 'role_id', 'phone', 'active'], 'required'],
            ['phone', function ($attribute, $params) {
                if (!preg_match('/7(\d){10}/', $this->phone)) {
                    $this->addError('phone', 'Номер телефона должен быт в формате 7xxxxxxxxxx');
                }
            }],

        ];
    }
}
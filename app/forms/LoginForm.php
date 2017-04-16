<?php

namespace app\forms;

use app\models\User;
use Yii;
use yii\base\Model;


class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            ['email', 'email'],
            [['email', 'password'], 'required'],
            ['password', 'checkAuth']
        ];
    }

    public function checkAuth($attribute){
        if (!User::login($this->email, $this->password)) {
            $this->addError('email', 'Неверный логин или пароль');
            $this->addError('password', 'Неверный логин или пароль');
        }
    }

}
<?php

namespace app\forms;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\Url;


class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $phone;
    public $captcha;

    public function rules()
    {
        return [
            ['name', 'string', 'length' => [4, 24]],
            ['phone', function ($attribute, $params) {
                if (!preg_match('/7(\d){10}/', $this->phone)) {
                    $this->addError('phone', 'Номер телефона должен быт в формате 7xxxxxxxxxx');
                }
            }],
            [['name', 'email'], 'checkUnique'],
            ['email', 'email'],
            [['email', 'password', 'name', 'phone'], 'required'],
            ['captcha', 'captcha'],
        ];
    }


    public function sendLink()
    {
        $link = $this->email . ':' . md5(\Yii::$app->params['salt'] . $this->email);
        $link = Url::to(['user/activate/' . $link], 'http');
        $body = 'Ваша ссылка для активации аккаунта: ' . $link;

        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setTextBody($body)
            ->send();

        return true;
    }

    public function checkUnique($attribute, $params) {
        if(User::findOne([$attribute => $this->$attribute])) {
            $this->addError($attribute, 'Пользователь с такимм данными уже существует');
        }
    }

}
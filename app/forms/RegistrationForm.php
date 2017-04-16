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
            ['name', 'string', 'length' => [2, 24]],
            ['phone', function ($attribute, $params) {
                if (!preg_match('/7(\d){10}/', $this->phone)) {
                    $this->addError('phone', 'Номер телефона должен быт в формате 7xxxxxxxxxx');
                }
            }],
            [['name', 'email'], 'checkUnique'],
            ['email', 'email'],
            [['email', 'password', 'name', 'phone'], 'required'],
            ['captcha', 'captcha','captchaAction'=>'user/captcha'],
        ];
    }


    /**
     * Отправляет ссылку на активацию аккаунта
     * @return bool
     */
    public function sendLink()
    {
        $link = $this->email . ':' . md5(\Yii::$app->params['salt'] . $this->email);
        $link = Url::to(['user/activate/' . $link], 'http');
        $body = 'Ваша ссылка для активации аккаунта: ' . $link;

        // из под дев окружения почта не ходит, поэтому так:
        return $body;

        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setTextBody($body)
            ->send();

        return true;
    }


    /**
     * проверка на уникальность имени и почты
     * @param $attribute
     * @param $params
     */
    public function checkUnique($attribute, $params)
    {
        if (User::findOne([$attribute => $this->$attribute])) {
            $this->addError($attribute, 'Пользователь с такимм данными уже существует');
        }
    }

}
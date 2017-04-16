<?php

namespace app\models;

use app\forms\RegistrationForm;
use yii\db\ActiveRecord;
use yii\base\Model as BaseModel;

class User extends ActiveRecord
{
    private static $_currentUser;

    public static function tableName()
    {
        return '{{tbl_user}}';
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * Перед созданием нового пользователя преобразует пароль в хеш
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->password = md5(\Yii::$app->params['salt'] . $this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Проверяет правильность логина-пароля, логинит
     * пользователя в случае правильной пары
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function login(string $email, string $password) : bool
    {
        $user = self::findOne([
            'email'     => $email,
            'password'  => md5(\Yii::$app->params['salt'] . $password),
            'active'    => 1,
        ]);


        if ($user) {
            self::setCurrentUser($user);
        }

        return !empty(self::$_currentUser);
    }


    /**
     * Выходит текущего пользователя
     */
    public static function logout()
    {
        self::$_currentUser = null;
        \Yii::$app->session->remove('user_id');
    }


    /**
     * Устанавливает текущего пользователя
     * @param User $user
     */
    public static function setCurrentUser(User $user)
    {
        \Yii::$app->session->set('user_id', $user->id);
        self::$_currentUser = $user;
    }


    /**
     * Возвращает текущего пользователя
     * @return static
     */
    public static function getCurrentUser()
    {
        if (empty(self::$_currentUser) && !empty($sessionUsedId = \Yii::$app->session->get('user_id'))) {
            if (!empty($user = self::findOne(['id' => $sessionUsedId, 'active' => 1])) ) {
                self::$_currentUser = $user;
            }
        }
        return self::$_currentUser;
    }


    /**
     * Создает пользователя, на вход ожидает асоциативный массив
     * @param $values
     * @return bool
     */
    public static function createFromArray($values)
    {
        $user = new self();
        $values = array_intersect_key($values, $user->getAttributes());
        foreach ($values as $columnName => $columnValue) {
            $user->$columnName = $columnValue;
        }

        $user->role_id  = 2;
        $user->active   = 0;

        return $user->save();
    }
}
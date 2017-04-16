<?php
/**
 * Created by PhpStorm.
 * User: sim
 * Date: 15.04.17
 * Time: 12:24
 */
namespace app\controllers;

use app\components\Access;
use app\forms\RegistrationForm;
use app\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        if (!Access::can(Yii::$app->controller->getRoute()) || empty($user = User::getCurrentUser())) {
            return $this->redirect('user/login');
        }

        return $this->render('index', [
            'user' => $user
        ]);
    }

    public function actionLogin()
    {
        $loginForm = new \app\forms\LoginForm();

        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate()) {
            return $this->redirect('/');
        }

        return $this->render('login', [
            'formModel' => $loginForm
        ]);
    }

    public function actionLogout()
    {
        User::logout();
        return $this->redirect('/');
    }

    public function actionRegistration()
    {
        $registrationForm = new RegistrationForm();

        if (
            $registrationForm->load(Yii::$app->request->post()) &&
            $registrationForm->validate() &&
            User::createFromArray(Yii::$app->request->post()['RegistrationForm']) &&
            $registrationForm->sendLink()
        ) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('registration', [
            'model' => $registrationForm,
        ]);
    }

    public function actionActivate($mail, $link)
    {
        // $mail = filter_var($mail, FILTER_VALIDATE_EMAIL);
        // результат такой проверки не совпадает с стандартной проверкой, используемой при реге. не подходит, хотя более правильный

        ($mailValidator = new DynamicModel(['email' => $mail]))->addRule('email', 'email')->validate();

        switch (true) {
            case ($mailValidator->hasErrors()):
                // невалидное мыло
                $templateVars['error'] = $mailValidator->getFirstError('email');
                break;
            case ( empty($user = User::findOne(['email' => $mail])) ):
                // несуществующее мыло
                $templateVars['error'] = 'Попытка активировать несуществующего пользователя';
                break;
            case (strlen($link) !== 32 || md5(\Yii::$app->params['salt'] . $mail) !== $link):
                // невалидная ссылка активации либо не соответсвует мылу
                $templateVars['error'] = 'Неверная ссылка активации';
                break;
            case $user->active == 1 :
                $templateVars['error'] = 'Пользователь уже активен';
                break;
            default:
                $user->active = 1;
                if (!$user->save()) {
                    // не удалось сохранить
                    $templateVars['error'] = 'Что-то пошло не так, попробуйте еще раз позднее';
                } else {
                    $templateVars['success'] = 'Пользователь активирован';
                    // все ок, логиним:
                    User::setCurrentUser($user);
                }
                break;
        }

        return $this->render('activate', $templateVars);
    }
}
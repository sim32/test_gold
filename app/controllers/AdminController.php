<?php
/**
 * Created by PhpStorm.
 * User: sim
 * Date: 15.04.17
 * Time: 12:24
 */
namespace app\controllers;

use app\components\Access;
use app\forms\admin\EditForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionIndex()
    {
        if (!Access::can('admin/index')) {
            return $this->render('/common/access_error',[]);
        }

        $users = User::find()->all();

        return $this->render('index', [
            'users' => $users
        ]);
    }

    public function actionEdit($user_id = null)
    {
        if (!Access::can('admin/edit')) {
            return $this->render('/common/access_error',[]);
        }

        $templateVars = [];

        if (empty($user_id)) {
            $user = new User();
        } else {
            $user = User::findOne(['id' => $user_id]);
            if (!$user) {
                throw new NotFoundHttpException('Пользователь не найден');
            }
        }

        $model = new EditForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $user->name = $model->name;
            $user->email = $model->email;
            $user->phone = $model->phone;
            $user->role_id = $model->role_id;
            $user->active = $model->active == 1;


            if ($user->save(false)) {
                $templateVars['success'] = 'Пользователь сохранен';
            } else {
                $templateVars['error'] = 'Что-то пошло не так';
            }
        } else {
            $model->setAttributes([
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'active' => $user->active,
                'phone' => $user->phone,
            ]);
        }

        return $this->render('edit', ['model' => $model, 'data' => $templateVars]);
    }

    public function actionDelete($user_id)
    {}
}
<?php
/**
 * Created by PhpStorm.
 * User: sim
 * Date: 15.04.17
 * Time: 12:24
 */
namespace app\controllers;

use app\forms\admin\SearchForm;
use app\components\Access;
use app\forms\admin\EditForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{

    /**
     * список пользователей
     * @return string
     */
    public function actionIndex()
    {
        if (!Access::can('admin/index')) {
            return $this->render('/common/access_error', []);
        }
        $userBuilder = User::find();

        $searchForm = new SearchForm();
        if ($searchForm->load(Yii::$app->getRequest()->post()) && $searchForm->validate()) {
            $filterValue = Yii::$app->getRequest()->post()['SearchForm'];
            if (!empty($filterValue['name'])) {
                $userBuilder->orWhere(['like', 'name', $filterValue['name']]);
            }

            if (!empty($filterValue['email'])) {
                $userBuilder->orWhere(['like', 'email', $filterValue['email']]);
            }

            if (!empty($filterValue['phone'])) {
                $userBuilder->orWhere(['like', 'phone', $filterValue['phone']]);
            }

            if (!empty($filterValue['role_id'])) {
                $userBuilder->orWhere(['=', 'role_id', $filterValue['role_id']]);
            }
        }

        $users = $userBuilder->all();

        return $this->render('index', [
            'searchForm' => $searchForm,
            'users' => $users
        ]);
    }


    /**
     * редактирование пользователя
     * @param null $user_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit($user_id = null)
    {
        if (!Access::can('admin/edit')) {
            return $this->render('/common/access_error', []);
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


    /**
     * удалить пользователя
     * @param $user_id
     * @return string
     */
    public function actionDelete($user_id)
    {
        $templateVars = [];

        $user = User::findOne(['id' => $user_id]);

        if (!$user) {
            $templateVars['error'] = 'Такого пользователя не существует';
        } else {
            if (!$user->delete()) {
                $templateVars['error'] = 'Что-то пошло не так';
            } else {
                $templateVars['success'] = 'Пользователь удален';
            }
        }

        return $this->render('delete', $templateVars);
    }
}
<?php

namespace app\components;


use app\models\Permission;
use app\models\User;

class Access
{

    /**
     * @param string $route
     * @return bool
     */
    public static function can(string $route) : bool
    {
        $permissionModel = Permission::find()
            ->where([
                'route' => $route,
                'role_id' => null
            ]);

        if (!empty($user = User::getCurrentUser())) {
            $permissionModel->orWhere(
                [
                    'route' => $route,
                    'role_id' => $user->role_id
                ]
            );
        }

        return !empty($permissionModel->one());
    }
}
<?php

namespace app\repositories\database;

use app\entities\User;
use app\repositories\contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::findOne($id);
    }

    public function findByAccessToken(string $token, $type = null): ?User
    {
        return User::findOne(['access_token' => $token]);
    }

    public function findByPhone(string $phone): ?User
    {
        return User::findOne(['phone' => $phone]);
    }

    public function add(User $user): User
    {
        $user->save(false);
        return $user;
    }
}
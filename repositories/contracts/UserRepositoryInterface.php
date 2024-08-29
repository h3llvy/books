<?php

namespace app\repositories\contracts;

use app\entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByAccessToken(string $token, $type = null): ?User;

    public function findByPhone(string $phone): ?User;

    public function add(User $user): User;
}
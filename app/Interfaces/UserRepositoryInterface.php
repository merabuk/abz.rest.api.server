<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getUsersWithPagination(int $count, int $page);
    public function getUsersByOffset(int $count, int $offset);
    public function saveUser(object $model);
    public function getUserById(int $id);
    public function getUserIdByEmail(string $email);
}

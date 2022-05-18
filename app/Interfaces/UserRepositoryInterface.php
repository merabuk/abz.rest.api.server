<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getUsersWithPagination(int $count, int $page);
    public function getUsersByOffset(int $count, int $offset);
    public function getUserById($id);
}

<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getUserById(int $id);
}

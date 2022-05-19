<?php

namespace App\Actions;

use App\Exceptions\NotFoundException;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class OffsetUser
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $count
     * @param int $offset
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function execute(int $count, int $offset)
    {
        $users = $this->repository->getUsersByOffset($count, $offset);

        if ($users->isEmpty()) {
            throw new NotFoundException();
        }

        return $users;
    }
}

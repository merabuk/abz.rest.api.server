<?php

namespace App\Actions;

use App\Exceptions\UserNotFoundException;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class GetUser
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function execute(int $id): User
    {
        $user = $this->repository->getUserById($id);

        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

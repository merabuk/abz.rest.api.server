<?php

namespace App\Actions;

use App\DTO\UserStoreDto;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserQueryException;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Transformers\UserMapper;
use Illuminate\Database\QueryException;

class SaveUser
{
    private UserRepositoryInterface $repository;
    private UserMapper $mapper;

    public function __construct(UserRepositoryInterface $repository, UserMapper $mapper)
    {
        $this->repository = $repository;
        $this->mapper = $mapper;
    }

    /**
     * @param UserStoreDto $dto
     *
     * @return User
     * @throws UserNotFoundException
     * @throws UserQueryException
     */
    public function execute(UserStoreDto $dto)
    {
        $userMap = $this->mapper->handle($dto);
        try {
            $this->repository->saveUser($userMap);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                throw new UserQueryException();
            }
        }

        $user = $this->repository->getUserIdByEmail($dto->getEmail());

        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

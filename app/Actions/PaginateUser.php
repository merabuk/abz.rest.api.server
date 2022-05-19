<?php

namespace App\Actions;

use App\Exceptions\NotFoundException;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateUser
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $count
     * @param int $page
     *
     * @return LengthAwarePaginator
     * @throws NotFoundException
     */
    public function execute(int $count, int $page): LengthAwarePaginator
    {
        $users = $this->repository->getUsersWithPagination($count, $page);

        if (! $users instanceof LengthAwarePaginator || $users->lastPage() < $page) {
            throw new NotFoundException();
        }

        return $users;
    }
}

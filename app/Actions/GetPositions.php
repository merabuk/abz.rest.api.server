<?php

namespace App\Actions;

use App\Exceptions\PositionNotFoundException;
use App\Interfaces\PositionRepositoryInterface;

class GetPositions
{
    /**
     * @var PositionRepositoryInterface
     */
    private $repository;

    public function __construct(PositionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     * @throws PositionNotFoundException
     */
    public function execute()
    {
        $positions = $this->repository->getAllPosition();

        if ($positions->isEmpty()) {
            throw new PositionNotFoundException();
        }

        return $positions;
    }
}

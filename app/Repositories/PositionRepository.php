<?php

namespace App\Repositories;

use App\Exceptions\PositionNotFoundException;
use App\Http\Resources\PositionCollection;
use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position as Model;

class PositionRepository extends CoreRepository implements PositionRepositoryInterface
{
    /**
     * @var string[]
     */
    protected array $columns = [
        'id',
        'name',
    ];

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @return PositionCollection
     * @throws PositionNotFoundException
     */
    public function getAllPosition()
    {
        $positions = $this->startCondition()->select($this->columns)->get();

        if ($positions->isEmpty()) {
            throw new PositionNotFoundException();
        }

        return PositionCollection::make($positions);
    }
}

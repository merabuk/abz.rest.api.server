<?php

namespace App\Repositories;

use App\Exceptions\PositionNotFoundException;
use App\Http\Resources\PositionCollection;
use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position as Model;

class PositionRepository extends CoreRepository implements PositionRepositoryInterface
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getAllPosition()
    {
        $columns = [
            'id',
            'name',
        ];

        $positions = $this->startCondition()->select($columns)->get();

        if ($positions->isEmpty()) {
            throw new PositionNotFoundException();
        }

        $response = PositionCollection::make($positions);

        return $response;
    }
}

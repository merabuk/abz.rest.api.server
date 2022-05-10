<?php

namespace App\Repositories;

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

        return $positions;
    }
}

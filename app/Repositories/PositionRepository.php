<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position as Model;

class PositionRepository extends CoreRepository implements PositionRepositoryInterface
{
    /**
     * @var string[]
     */
    protected $columns = [
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
     * @return mixed
     */
    public function getAllPosition()
    {
        return $this->startCondition()->select($this->columns)->get();
    }
}

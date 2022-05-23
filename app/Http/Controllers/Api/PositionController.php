<?php

namespace App\Http\Controllers\Api;

use App\Actions\GetPositions;
use App\Http\Resources\PositionCollection;
use App\Interfaces\PositionRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PositionController extends ApiController
{
    /**
     * @var PositionRepositoryInterface
     */
    protected $positionRepository;

    public function __construct()
    {
        $this->positionRepository = app(PositionRepositoryInterface::class);
    }

    /**
     * @param GetPositions $action
     *
     * @return PositionCollection
     * @throws \App\Exceptions\PositionNotFoundException
     */
    public function index(GetPositions $action): PositionCollection
    {
        $positions = $action->execute();

        return PositionCollection::make($positions);
    }
}

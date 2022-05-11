<?php

namespace App\Http\Controllers;

use App\Interfaces\PositionRepositoryInterface;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends BaseController
{
    /**
     * @var PositionRepositoryInterface
     */
    protected PositionRepositoryInterface $positionRepository;

    public function __construct()
    {
        $this->positionRepository = app(PositionRepositoryInterface::class);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $positions = $this->positionRepository->getAllPosition();

        return response()->json($positions, 200);
    }
}

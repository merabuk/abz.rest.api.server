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
        $data['success'] = false;
        $position = $this->positionRepository->getAllPosition();
        if ($position->isEmpty()) {
            $data['message'] = 'Positions not found';
            return response()->json($data, 422);
        }
        $data['positions'] = $position;

        return response()->json($data, 200);
    }
}

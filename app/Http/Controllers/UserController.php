<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserValidateRouteParameterException;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepositoryInterface::class);
    }
    public function index()
    {
        return __METHOD__;
    }

    public function create()
    {
        return __METHOD__;
    }

    public function show($id)
    {
        $data = $this->userRepository->getUserById($id);

        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexUsersRequest;
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
    public function index(IndexUsersRequest $request)
    {
        $count = $request->input('count', 5);
        $offset = $request->input('offset', 0);
        $page = $request->input('page', 1);

        if ($request['offset'] && $request['offset'] > 0) {
            $data = $this->userRepository->getUsersByOffset($count, $offset);
        } else {
            $data = $this->userRepository->getUsersWithPagination($count, $page);
        }

        return response()->json($data, 200);
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

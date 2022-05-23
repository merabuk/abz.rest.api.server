<?php

namespace App\Http\Controllers\Api;

use App\Actions\GetUser;
use App\Actions\OffsetUser;
use App\Actions\PaginateUser;
use App\Actions\SaveUser;
use App\Exceptions\UserValidateRouteParameterException;
use App\Http\Requests\Api\CreateUsersRequest;
use App\Http\Requests\Api\IndexUsersRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\BaseEntity;
use App\DTO\UserStoreDto;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    /**
     * @param IndexUsersRequest $request
     * @param PaginateUser $paginateUserAction
     * @param OffsetUser $offsetUserAction
     *
     * @return JsonResponse
     * @throws \App\Exceptions\NotFoundException
     */
    public function index(IndexUsersRequest $request, PaginateUser $paginateUserAction, OffsetUser $offsetUserAction): JsonResponse
    {
        $count = $request->input('count', BaseEntity::COUNT);
        $offset = $request->input('offset', BaseEntity::OFFSET);
        $page = $request->input('page', BaseEntity::PAGE);

        if ($offset && $offset > 0) {
            $collection = $offsetUserAction->execute($count, $offset);
        } else {
            $collection = $paginateUserAction->execute($count, $page);
        }

        $data = UserCollection::make($collection);

        return response()->json($data, 200);
    }

    public function store(CreateUsersRequest $request, SaveUser $action)
    {
        $userDto = UserStoreDto::fromRequest($request);
        $user = $action->execute($userDto);

        $data = [
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered'
        ];

        return response()->json($data, 200);
    }

    /**
     * @param GetUser $action
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws UserValidateRouteParameterException
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function show(GetUser $action, $id): JsonResponse
    {
        if (!is_numeric($id)) {
            throw new UserValidateRouteParameterException();
        }

        $data = UserResource::make($action->execute($id));

        return response()->json($data, 200);
    }
}

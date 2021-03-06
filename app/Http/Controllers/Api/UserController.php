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
use App\Http\Resources\UserCreatedResource;
use App\Http\Resources\UserResource;
use App\Models\BaseEntity;
use App\DTO\UserStoreDto;

class UserController extends ApiController
{
    /**
     * @param IndexUsersRequest $request
     * @param PaginateUser $paginateUserAction
     * @param OffsetUser $offsetUserAction
     *
     * @return UserCollection
     * @throws \App\Exceptions\NotFoundException
     */
    public function index(
        IndexUsersRequest $request,
        PaginateUser $paginateUserAction,
        OffsetUser $offsetUserAction): UserCollection
    {
        $count = $request->input('count', BaseEntity::COUNT);
        $offset = $request->input('offset', BaseEntity::OFFSET);
        $page = $request->input('page', BaseEntity::PAGE);

        if ($offset && $offset > 0) {
            $collection = $offsetUserAction->execute($count, $offset);
        } else {
            $collection = $paginateUserAction->execute($count, $page);
        }

        return UserCollection::make($collection);
    }

    /**
     * @param CreateUsersRequest $request
     * @param SaveUser $action
     *
     * @return UserCreatedResource
     * @throws \App\Exceptions\UserNotFoundException
     * @throws \App\Exceptions\UserQueryException
     */
    public function store(CreateUsersRequest $request, SaveUser $action): UserCreatedResource
    {
        $userDto = UserStoreDto::fromRequest($request);
        $user = $action->execute($userDto);

        return UserCreatedResource::make($user);
    }

    /**
     * @param GetUser $action
     * @param $id
     *
     * @return UserResource
     * @throws UserValidateRouteParameterException
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function show(GetUser $action, $id): UserResource
    {
        if (!is_numeric($id)) {
            throw new UserValidateRouteParameterException();
        }

        $user = $action->execute($id);

        return UserResource::make($user);
    }
}

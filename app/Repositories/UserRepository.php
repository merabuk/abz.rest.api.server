<?php

namespace App\Repositories;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserValidateRouteParameterException;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User as Model;

class UserRepository extends CoreRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getUserById($id)
    {
        if (!is_numeric($id)) {
            return throw new UserValidateRouteParameterException();
        }

        $user = $this->startCondition()->find($id);
        if (!$user) {
            return throw new UserNotFoundException();
        }

        $response = UserResource::make($user);

        return $response;
    }
}

<?php

namespace App\Repositories;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserValidateRouteParameterException;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserShowResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository extends CoreRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getUsersWithPagination(int $count, int $page)
    {
        $columns = [
            'id',
            'name',
            'email',
            'phone',
            'position_id',
            'created_at',
            'photo'
        ];

        $users = $this->startCondition()
            ->select($columns)
            ->orderBy('id')
            ->with(['position:id,name'])
            ->paginate($count)
            ->withQueryString();

        $users->appends(['count' => $count]);

        if ($users->lastPage() > $page) {
            $usersResource = UserCollection::make($users);
        } else {
            throw new NotFoundHttpException;
        }

        return $usersResource;
    }

    public function getUsersByOffset(int $count, int $offset)
    {
        $users = $this->startCondition()
            ->skip($offset)
            ->take($count)
            ->orderBy('id')
            ->get();

        return $users;
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

        return UserShowResource::make($user);
    }
}

<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends CoreRepository implements UserRepositoryInterface
{
    /**
     * @var string[]
     */
    protected array $columns = [
        'id',
        'name',
        'email',
        'phone',
        'position_id',
        'created_at',
        'photo'
    ];

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param int $count
     * @param int $page
     *
     * @return mixed
     */
    public function getUsersWithPagination(int $count, int $page)
    {
        $users = $this->startCondition()
            ->select($this->columns)
            ->orderBy('id')
            ->with(['position:id,name'])
            ->paginate($count)
            ->withQueryString();

        $users->appends(['count' => $count]);

        return $users;
    }

    /**
     * @param int $count
     * @param int $offset
     *
     * @return mixed
     */
    public function getUsersByOffset(int $count, int $offset)
    {
        $users = $this->startCondition()
            ->select($this->columns)
            ->skip($offset)
            ->take($count)
            ->orderBy('id')
            ->get();

        return  $users;
    }


    public function saveUser(object $model)
    {
        return DB::transaction(function () use ($model) {
            $model->password = Hash::make('password');
            $model->save();
        });
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getUserById(int $id)
    {
        return $this->startCondition()->find($id);
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function getUserIdByEmail(string $email)
    {
        return $this->startCondition()->where('email', $email)->first();
    }
}

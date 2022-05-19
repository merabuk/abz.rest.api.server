<?php

namespace App\Transformers;

use App\DTO\UserStoreDto;
use App\Models\User;

class UserMapper
{
    /**
     * @param  UserStoreDto  $dto
     *
     * @return User
     */
    public function handle(UserStoreDto $dto): User
    {
        return new User([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'phone' => $dto->getPhone(),
            'position_id' => $dto->getPositionId()
        ]);
    }
}

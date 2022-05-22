<?php

namespace App\Actions;

use App\DTO\UserStoreDto;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserQueryException;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Transformers\UserMapper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class SaveUser
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;
    /**
     * @var UserMapper
     */
    private $mapper;

    /**
     * @var CropImage
     */
    private $cropImage;

    public function __construct(
        UserRepositoryInterface $repository,
        UserMapper $mapper,
        CropImage $cropImage
    )
    {
        $this->repository = $repository;
        $this->mapper = $mapper;
        $this->cropImage = $cropImage;
    }

    /**
     * @param UserStoreDto $dto
     *
     *
     * @throws UserNotFoundException
     * @throws UserQueryException
     */
    public function execute(UserStoreDto $dto)//: User
    {
        $userMap = $this->mapper->handle($dto);

        $photoPath = $this->cropImage->execute($userMap->photo);
        $fullUserPhotoPath = env('APP_URL').'/storage/'.$photoPath;
        $userMap->photo = $fullUserPhotoPath;
        try {
            $this->repository->saveUser($userMap);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                Storage::disk('public')->delete($photoPath);
                throw new UserQueryException();
            }
        }

        $user = $this->repository->getUserIdByEmail($dto->getEmail());

        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

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

    /**
     * @var SaveImage
     */
    private $saveImage;

    /**
     * @var DeleteImage
     */
    private $deleteImage;

    public function __construct(
        UserRepositoryInterface $repository,
        UserMapper $mapper,
        CropImage $cropImage,
        SaveImage $saveImage,
        DeleteImage $deleteImage
    )
    {
        $this->repository = $repository;
        $this->mapper = $mapper;
        $this->cropImage = $cropImage;
        $this->saveImage = $saveImage;
        $this->deleteImage = $deleteImage;
    }

    /**
     * @param UserStoreDto $dto
     *
     * @return User
     * @throws UserNotFoundException
     * @throws UserQueryException
     */
    public function execute(UserStoreDto $dto): User
    {
        $userMap = $this->mapper->handle($dto);

        $photo = $this->cropImage->execute($userMap->photo);
        $photoPath = $this->saveImage->execute($photo);
        $fullUserPhotoPath = env('APP_URL').'/storage/'.$photoPath;
        $userMap->photo = $fullUserPhotoPath;
        try {
            $this->repository->saveUser($userMap);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                $this->deleteImage->execute($photoPath);
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

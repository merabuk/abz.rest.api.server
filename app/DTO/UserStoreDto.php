<?php

namespace App\DTO;

use Illuminate\Http\Request;

class UserStoreDto
{
    private $name;
    private $email;
    private $phone;
    private $positionId;
    private $photo;

    public function __construct(
        string $name,
        string $email,
        string $phone,
        int $positionId,
        object $photo
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->positionId = $positionId;
        $this->photo = $photo;
    }

    public static function fromRequest(Request $request): UserStoreDto
    {
        return new static(
            $request->get('name'),
            $request->get('email'),
            $request->get('phone'),
            $request->get('position_id'),
            $request->file('photo')
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getPositionId(): int
    {
        return $this->positionId;
    }

    /**
     * @return object
     */
    public function getPhoto(): object
    {
        return $this->photo;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

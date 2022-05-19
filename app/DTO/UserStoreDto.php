<?php

namespace App\DTO;

use Illuminate\Http\Request;

class UserStoreDto
{
    private string $name;
    private string $email;
    private string $phone;
    private int $positionId;

    public function __construct(
        string $name,
        string $email,
        string $phone,
        int $positionId
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->positionId = $positionId;
    }

    public static function fromRequest(Request $request): UserStoreDto
    {
        return new static(
            $request->get('name'),
            $request->get('email'),
            $request->get('phone'),
            $request->get('position_id')
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
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

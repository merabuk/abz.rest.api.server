<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user =  [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'position' => $this->resource->position->name,
            'position_id' => $this->resource->position_id,
            'registration_timestamp' => $this->resource->created_at->timestamp,
            'photo' => $this->resource->photo
        ];

        if (isset($this->resource->updated_at)) {
            unset($user['registration_timestamp']);
            return [
                'success' => true,
                'user' => $user
            ];
        }

        return $user;
    }
}

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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position->name,
            'position_id' => $this->position_id,
            $this->mergeWhen(is_null($this->updated_at), [
                'registration_timestamp' => $this->created_at->timestamp,
            ]),
            'photo' => $this->photo
        ];

        if (isset($this->updated_at)) {
            return [
                'success' => true,
                'user' => $user
            ];
        }

        return $user;
    }
}

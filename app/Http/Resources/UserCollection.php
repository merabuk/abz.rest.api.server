<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $users = UserResource::collection($this->collection);

        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'success' => true,
                'page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
                'total_users' => $this->resource->total(),
                'count' => $this->resource->perPage(),
                'links' => [
                    'next_url' => $this->resource->nextPageUrl(),
                    'prev_url' => $this->resource->previousPageUrl(),
                ],
                'users' => $users,
            ];
        }
        return [
            'success' => true,
            'users' => $users,
        ];
    }
}

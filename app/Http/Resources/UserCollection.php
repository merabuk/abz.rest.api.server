<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'users';

    /**
     * The additional meta data that should be added to the resource response.
     *
     * Added during response construction by the developer.
     *
     * @var array
     */
    public $additional = [
        'success' => true
    ];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'users' => UserResource::collection($this->collection),
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            $paginator = [
                'page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
                'total_users' => $this->resource->total(),
                'count' => $this->resource->perPage(),
                'links' => [
                    'next_url' => $this->resource->nextPageUrl(),
                    'prev_url' => $this->resource->previousPageUrl(),
                ]
            ];
            $responseData = $response->getData(true);
            unset($responseData['meta'], $responseData['links']);
            $result = array_merge($paginator, $responseData);
            $response->setData($result);
        }
    }
}

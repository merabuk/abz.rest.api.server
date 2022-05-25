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

    public $additional = [
        'success' => true
    ];


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

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

//    private $pagination;
//
//    public function __construct($resource)
//    {
//        if ($resource instanceof LengthAwarePaginator) {
//            $this->pagination = [
//                'page' => $resource->currentPage(),
//                'total_pages' => $resource->lastPage(),
//                'total_users' => $resource->total(),
//                'count' => $resource->perPage(),
//                'links' => [
//                    'next_url' => $resource->nextPageUrl(),
//                    'prev_url' => $resource->previousPageUrl(),
//                ],
//            ];
//            $resource = $resource->getCollection();
//        }
//
//        parent::__construct($resource);
//    }
//
//    public function toArray($request)
//    {
//        return [
//            'pagination' => $this->pagination,
//            'users' => $this->collection
//        ];
//    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            $this->mergeWhen($this->resource instanceof LengthAwarePaginator, [
                'page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'total_users' => $this->total(),
                'count' => $this->perPage(),
                'links' => [
                    'next_url' => $this->nextPageUrl(),
                    'prev_url' => $this->previousPageUrl(),
                ],
            ]),
            'users' =>  UserResource::collection($this->collection),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [];

    }
}

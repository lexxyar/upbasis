<?php

namespace Lexxsoft\Upbasis\Http\Resources;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\JsonResource;

class UnauthorizedResource extends JsonResource
{
    public static $wrap = null;

    public function __construct()
    {
        parent::__construct([]);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'error',
            'message' => (new AuthorizationException)->getMessage(),
        ];
    }
}

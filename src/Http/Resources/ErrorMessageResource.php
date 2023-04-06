<?php

namespace Lexxsoft\Upbasis\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorMessageResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(public string $message, public string $code = '')
    {
        parent::__construct([]);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return [
            'type' => 'error',
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}

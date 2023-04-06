<?php

namespace Lexxsoft\Upbasis\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessMessageResource extends JsonResource
{
    public static $wrap = null;

    public $message;
    public $code;

    public function __construct($sMessage = 'Success', $sCode = '200')
    {
        parent::__construct([]);
        $this->message = $sMessage;
        $this->code = $sCode;
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
            'type' => 'success',
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}

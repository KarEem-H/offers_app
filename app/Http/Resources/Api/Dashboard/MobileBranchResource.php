<?php

namespace App\Http\Resources\Api\Dashboard;

use App\Services\TamaraService;
use Illuminate\Http\Resources\Json\JsonResource;

class MobileBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
        ];
    }
}

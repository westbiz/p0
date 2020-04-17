<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ContinentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'parent' => $this->parentcontinent->cn_name,
            'cn_name' => $this->cn_name,
            'en_name' => $this->en_name,
            'created_at'=> (string)$this->created_at,
            'updated_at'=> (string)$this->updated_at,
            'countries' => CountryResource::collection($this->whenLoaded('continentcountries')),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CountryResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		// return parent::toArray($request);
		return [
			'id' => $this->id,
			'cname' => $this->cname,
			'continentlocated' => ContinentResource::collection($this->whenLoaded('continentlocation')), 
			// 'continent' => [
			// 	'id' => $this->continent->id,
			// 	'cn_name' => $this->continent->cn_name,
			// 	'en_name' =>$this->continent->en_name,
			// 	'url'=> url('api/v1/continents/' . $this->continent_id),
			// ],
			'name' => $this->name, 
			'lower_name' => $this->lower_name, 
			'country_code' => $this->country_code, 
			'full_name' => $this->full_name, 
			'full_cname' => $this->full_cname, 
			'remark' => $this->remark,
			'created_at'=> (string)$this->created_at,
			'updated_at'=> (string)$this->updated_at,			
			'cities' => WorldcityResource::collection($this->whenLoaded('cities')),
		];

	}

	public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
	}
	
}

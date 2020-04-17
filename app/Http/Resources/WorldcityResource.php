<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WorldcityResource;
use Carbon\Carbon;

class WorldcityResource extends JsonResource {
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
			'text' => $this->cn_name,
			'country' => $this->country->cname,
			// 'country' => [
			// 	'name'=>$this->country->cname, 
			// 	'url'=> url('api/v1/countries/' . $this->country_id),
			// ],
			'state' => $this->state, 
			'name' =>$this->name, 
			'lower_name'=>$this->lower_name, 
			'cn_state'=>$this->cn_state, 
			'cn_name'=>$this->cn_name, 
			'city_code'=>$this->city_code, 
			'state_code'=>$this->statecode, 
			'url'=> url('api/v1/worldcities/' . $this->id),
			'created_at'=> (string)$this->created_at,
            'updated_at'=> (string)$this->updated_at,
			// 'created_at'=> Carbon::parse($this->created_at)->toDateTimeString(),
            // 'updated_at'=> Carbon::parse($this->updated_at)->toDateTimeString(),
		];
	}

	//with方法，可以获取数据库记录以外的其他相关数据
	public function with($request) {
		return [
			'links' => [
				'self' => url('api/v1/worldcities/' . $this->id),
			],
		];
	}
}

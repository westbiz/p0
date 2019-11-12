<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    //
	protected $table = 'tx_destinations';


	// 国家一对多
	public function country() {
		return $this->belongsTo(Country::class, 'country_id', 'id');
	}

	// 城市一对多
	public function city() {
		return $this->belongsTo(Worldcity::class, 'city_id', 'id');
	}

}
<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model {
	//
	protected $table = 'tx_destinations';

	//字段
	protected $fillable = [
		'name', 'parent_id', 'country_id', 'city_id', 'type_id', 'order', 'promotion', 'active', 'description',
	];

	// 国家一对多
	public function country() {
		return $this->belongsTo(Country::class, 'country_id', 'id');
	}

	// 城市一对多
	public function city() {
		return $this->belongsTo(Worldcity::class, 'city_id', 'id');
	}

	//一对多
	public function destinationtype() {
		return $this->belongsTo(Destinationtype::class, 'type_id', 'id');
	}

	// 类型 多对多
	public function types() {
		return $this->belongsToMany(Destinationtype::class, 'tx_destinations_types', 'destination_id', 'type_id');

	}

}

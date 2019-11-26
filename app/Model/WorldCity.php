<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorldCity extends Model {
	//
	protected $table = 't_world_cities';

	protected $casts = [
		'neighbour' => 'json',
	];

	protected $fillable = [
		'country_id', 'parent_id', 'state', 'name', 'lower_name', 'cn_state', 'cn_name', 'city_code', 'state_code', 'active', 'is_island', 'promotion', 'capital', 'is_departure',
	];

	// 中国国内城市
	public function scopeChinacities() {
		return $this->where('country_id', 101);
	}

	// 港澳台
	public function scopeGangaotai($query) {
		$areas = collect(['香港', '澳门', '台湾']);
		return $query->whereIn('cn_state', $areas)->where('active', 1);
	}

	//一对多反向，国家
	public function country() {
		return $this->belongsTo(Country::class, 'country_id', 'id');
	}

	// 一对多
	public function destinations() {
		return $this->hasMany(Destination::class, 'city_id', 'id');
	}

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	//
	protected $table = 't_countries';

	protected $fillable = [
		'continent_id', 'name', 'lower_name', 'country_code', 'full_name', 'cname', 'full_name', 'remark', 'active', 'is_island', 'promotion',
	];

	//海岛
	public function scopeIsland() {
		return $this->where('is_island', 1);
	}

	//一对多，大洲
	public function continent() {
		return $this->belongsTo(Continent::class, 'continent_id', 'id');
	}

	//多对多，大洲国家地区地理位置
	public function continentlocation() {
		return $this->belongsToMany(Continent::class, 't_country_continent', 'country_id', 'continent_id');
	}

	//一对多反向，国家
	public function cities() {
		return $this->hasMany(Worldcity::class, 'country_id', 'id');
	}
}

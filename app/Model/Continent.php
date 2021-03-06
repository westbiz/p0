<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model {
	//
	protected $table = 't_continents';

	protected $dates = ['created_at', 'updated_at'];

	protected $fillable = [
		'cn_name', 'parent_id', 'en_name',
	];

	//一对多，多个国家
	public function countries() {
		return $this->hasmany(Country::class, 'continent_id', 'id');
	}

	//多对多，大洲地区多个国家-地理位置
	public function continentcountries() {
		return $this->belongsToMany(Country::class, 't_country_continent', 'continent_id', 'country_id');
	}

	//一对多，多个子类
	public function childrencontinent() {
		return $this->hasMany(Continent::class, 'parent_id', 'id');
	}

	//反向
	public function parentcontinent() {
		return $this->belongsTo(Continent::class, 'parent_id', 'id');
	}
}

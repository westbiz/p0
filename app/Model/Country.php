<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	//
	protected $table = 't_countries';

	protected $dates = ['created_at', 'updated_at'];

	protected $fillable = [
		'continent_id', 'name', 'lower_name', 'country_code', 'full_name', 'cname', 'full_cname', 'remark', 'active', 'is_island', 'promotion',
	];

	//海岛
	public function scopeIsland() {
		return $this->where('is_island', 1);
	}

	// 国外
	public function scopeAbroad() {
		$collections = collect([100,101,75,71]);
		return $this->whereNotIn('id', $collections);
	}

	// 港澳台
	public function scopeGangaotai() {
		$areas = collect([71, 75, 100]);
		return $this->whereIn('id', $areas);
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

	//一对多，worldcities
	public function options() {
		return $this->hasMany(Worldcity::class, 'country_id', 'id')
			->select('id', 'cn_name');
	}

	protected function transformer($items) {
		$data = [];
		foreach ($items ?? [] as $item) {
			$data[] = [
				'id' => $item->id,
				'label' => $item->cname,
				// 'text' => $item->cn_name,
				// 'country' => $item->country_id,
				'options' => $item->cities,
			];
		}
		return $data;
	}

}

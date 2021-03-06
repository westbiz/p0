<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorldCity extends Model {
	//
	protected $table = 't_world_cities';

	protected $dates = ['created_at', 'updated_at'];

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
	public function scopeGangaotai() {
		$areas = collect([71, 75, 100]);
		return $this->whereIn('country_id', $areas);
	}

	//世界城市，除大陆及港澳台以外城市
	public function scopeWorldcities() {
		$areas = collect(['71', '75', '101', '100']);
		return $this->whereNotIn('country_id', $areas);
	}

	//预备删除
	public function scopeXibei() {
		$states = collect(['陕西', '甘肃', '青海', '新疆', '宁夏']);
		return $this->whereIn('cn_state', $states);
	}

	//一对多反向，国家
	public function country() {
		return $this->belongsTo(Country::class, 'country_id', 'id');
	}

	//一对多，worldcities
	public function options() {
		return $this->hasMany(Worldcity::class, 'country_id', 'id')
			->select('id', 'cn_name');
	}

	// 一对多
	public function destinations() {
		return $this->hasMany(Destination::class, 'city_id', 'id');
	}

	// 目的地城市，多对多
	public function products() {
		return $this->belongsToMany(Product::class, 'tx_city_products', 'city_id', 'product_id');
	}

}

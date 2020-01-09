<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	//
	protected $table = "tx_products";

	protected $fillable = ['name', 'category_id', 'day', 'night', 'star', 'attributes', 'summary', 'route', 'content', 'active'];

	// 多对一
	public function category() {
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	// 目的地城市，多对多
	public function cities() {
		return $this->belongsToMany(Worldcity::class, 'tx_city_products', 'product_id', 'city_id');
	}

	public function chinacities() {
		return $this->belongsToMany(ChinaArea::class, 'tx_chinacity_products', 'product_id', 'city_id');
	}
}

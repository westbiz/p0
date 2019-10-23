<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attrvalue extends Model {
	//
	protected $table = 'p_attrvalues';

	protected $fillable = [
		'catattr_id', 'attrvalue', 'order', 'active',
	];

	//
	//属于多个属性
	public function attribute() {
		return $this->belongsTo(Attribute::class, 'catattr_id', 'id');
	}

	//
	//多个商品属性值
	public function product() {
		return $this->belongsToMany(Product::class, 'p_attrvalue_products', 'attrvalue_id', 'product_id');
	}

	//分类、属性 多对多
	public function categories() {
		return $this->belongsToMany(Category::class, 'p_catattr_category', 'catattr_id', 'category_id');
	}

}

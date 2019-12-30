<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChinaArea extends Model
{
    //
    protected $table = 't_areas';

    //字段
	protected $fillable = [
		// level字段：地区级别（1:省份province,2:市city,3:区县district,4:街道street）
		'areaCode','areaName','active','level','cityCode','center','parent_id',
	];



	public function scopeShengqu() {
		return $this->where('level', 1);
	}

	public function scopeChengshi() {
		return $this->where('level', 2);
	}

	public function scopeQuxian() {
		return $this->where('level', 3);
	}

	//三级联动
	public function parent() {
		return $this->belongsTo(ChinaArea::class, 'parent_id', 'id');
	}

	public function children() {
		return $this->hasMany(ChinaArea::class, 'parent_id', 'id');
	}

	public function brothers() {
		return $this->parent->children();
	}

	public static function options($id) {
		if (!$self = static::find($id)) {
			return [];
		}
		return $self->brothers()->pluck('areaName', 'id');
	}
}

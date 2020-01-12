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


	public function getAreaNameAttribute($value)
	{
		$pattern = array("自治区", "自治州", "省", "市", '特别行政区', '回族', '维吾尔', '壮族');
		$replace = '';
		return str_replace($pattern, $replace, $value);
	}


	public function scopeProvincial() {
		// 省区直辖市、特别行政区
		$provincial = collect([2,20,37,217,348,464,579,793,810,920,1021,1043,1238,1350,
			1505,1798,1935,2079,2205,2236,2580,2726,2808,2926,3027,3080,3108,3228,
			3229,3251,]);
		return $this->whereIn('id', $provincial);
	}

	public function scopeShengqu() {
		return $this->where('level', 1);
	}

	public function scopeDishi() {
		return $this->where('level', 2);
	}

	public function scopeQuxian() {
		return $this->where('level', 3);
	}


	// 港澳台
	public function scopeGangaotai($query) {
		// 港澳台id
		$areas = collect([3229,3251,3228]);
		return $query->whereIn('id', $areas);
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

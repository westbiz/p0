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


    public function children()
    {
    	return $this->hasMany(ChinaArea::class,'parent_id','id');
    }

    public function parentarea()
    {
    	return $this->belongsTo(ChinaArea::class,'parent_id','id');
    }
}

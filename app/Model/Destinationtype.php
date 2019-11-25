<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Destinationtype extends Model {
	//
	protected $table = 'tx_destinationtype';

	protected $fillable = [
		'name', 'parent_id', 'order', 'description',
	];

	// // 一对多
	// public function destinations() {
	// 	return $this->hasMany(Destination::class, 'type_id', 'id');
	// }

	//目的地 多对多
	public function destinations() {
		return $this->belongsToMany(Destination::class, 'tx_destinations_types', 'type_id', 'destination_id');
	}

	//一对多父类
	public function childtypes() {
		return $this->hasMany(Destinationtype::class, 'parent_id', 'id');
	}

	//一对多逆向
	public function parenttype() {
		return $this->belongsTo(Destinationtype::class, 'parent_id', 'id');
	}
}

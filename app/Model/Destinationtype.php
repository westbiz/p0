<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Destinationtype extends Model {
	//
	protected $table = 'tx_destinationtype';

	protected $fillable = [
		'name', 'parent_id', 'order', 'description',
	];

	public function destinations() {
		return $this->hasMany(Destination::class, 'type_id', 'id');
	}
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	//
	protected $table = 'tx_categories';

	protected $fillable = [
		'name', 'parent_id', 'order', 'description', 'active',
	];
}

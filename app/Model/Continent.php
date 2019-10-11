<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model {
	//
	protected $table = 't_continents';

	protected $fillable = [
		'cn_name', 'parent_id', 'en_name',
	];
}

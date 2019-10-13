<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorldCity extends Model
{
    //
    protected $table = 't_world_cities';

	protected $casts = [
		'neighbour' => 'json',
	];

	protected $fillable = [
		'country_id', 'state', 'name', 'lower_name', 'cn_state', 'cn_name', 'city_code', 'state_code', 'active', 'is_island', 'promotion', 'capital', 'is_departure', 
	];


}

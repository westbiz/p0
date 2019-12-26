<?php

namespace App\Http\Controllers;

use App\Model\Worldcity;
use App\Model\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorldcityController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	//选项过多，可通过ajax方式动态分页载入选项
	public function getchinacitiesbykeyword(Request $request) {
		$q = $request->get('q');
		return Worldcity::chinacities()
			->where('cn_state', 'like', "%$q%")
			->orWhere('cn_name', 'like', "%$q%")
			->paginate(null, ['id', DB::Raw('concat(cn_state," 》",cn_name) as text')]);
	}

	// 用wherehas ,q筛选的 约束到关联关系条件
	public function getcitieswithdesinationwords(Request $request) {
		$q = $request->get('q');

		// 当 city有相似关键字， cn_state 不为空时，
		// 当 city有相似关键字， cn_state，为空时，
		// 当 destination 有相似关键字
		$citieswithstate = Worldcity::where('cn_name', 'like', "%$q%")
			->whereNotNull('cn_state')->get();
		$citieswithoutstate = 	Worldcity::where('cn_name', 'like', "%$q%")
			->whereNull('cn_state')->get();
		// dd($citieswithoutstate);
		if ($citieswithstate->isNotEmpty()) {
			$data = Worldcity::select(['id', DB::Raw('concat(cn_state," 》",cn_name) as text')])
				->where(function ($query) use ($q) {
					$query->whereNotNull('cn_state')->where('cn_state', 'like', "%$q%");
				})
				->orWhere(function ($query) use ($q) {
					$query->whereNotNull('cn_state')->where('cn_name', 'like', "%$q%");
				})
				->orWhereHas('destinations', function ($query) use ($q) {
					$query->whereNotNull('cn_state')->select('id', 'name', 'city_id')
						->where('name', 'like', "%$q%");
				})
				->paginate();
		} 
		elseif ($citieswithoutstate->isNotEmpty()) {
			
			$data = DB::table('t_world_cities')
				->leftJoin('t_countries','t_world_cities.country_id','=','t_countries.id')
				->select(['t_world_cities.id', DB::Raw('concat(t_countries.cname," 》",t_world_cities.cn_name) as text')])
				// ->get();
				// ->whereNull('w.cn_state')->where('w.cn_name', 'like', "%$q%")
				->paginate();
		} 
		else {
			// $data = Worldcity::select(['id', DB::Raw('cn_name as text')])
			// 	->where(function ($query) use ($q) {
			// 		$query->whereNotNull('cn_state')->where('cn_state', 'like', "%$q%");
			// 	})
			// 	->orWhere(function ($query) use ($q) {
			// 		$query->whereNotNull('cn_state')->where('cn_name', 'like', "%$q%");
			// 	})
			// 	->orWhere(function ($query) use ($q) {
			// 		$query->whereNull('cn_state')->where('cn_name', 'like', "%$q%");
			// 	})
			// 	->orWhereHas('destinations', function ($query) use ($q) {
			// 		$query->whereNotNull('cn_state')->select('id', 'name', 'city_id')
			// 			->where('name', 'like', "%$q%");
			// 	})
			// 	->paginate();
				echo "string";
		}

		// $data = Worldcity::whereHas('destinations', function ($query) use ($q) {
		// 	$query->select('id', 'name', 'city_id')
		// 		->where('name', 'like', "%$q%");
		// })
		// 	->orWhere('cn_state', 'like', "%$q%")
		// 	->orWhere('cn_name', 'like', "%$q%")
		// 	->paginate(null, ['id', DB::Raw('concat(cn_state," 》",cn_name) as text')]);
		return $data;
	}

	public function getabroadcitiesbycountry(Request $request) {
		$q = $request->get('q');
		return DB::table('t_world_cities as worldcity')->rightjoin('t_countries as country', 'country.id', '=', 'worldcity.country_id')
		// ->select('country.cname as label','worldcity.id','worldcity.cn_name as text')
			->select('worldcity.id', DB::Raw('concat(country.cname," 》 ",worldcity.cn_name) as text'))
			->where('country.cname', 'like', "%$q%")
			->orWhere('worldcity.cn_name', 'like', "%$q%")
			->orWhere('worldcity.cn_state', 'like', "%$q%")
			->paginate();
	}

	//选项过多，可通过ajax方式动态分页载入选项
	public function allcities(Request $request) {
		$q = $request->get('q');
		// return Worldcity::chinacities()
		return Worldcity::where('cn_name', 'like', "%$q%")
			->orWhere('name', 'like', "%$q%")
			->orWhere('city_code', 'like', "%$q%")
			->orWhere('cn_state', 'like', "%$q%")
			->paginate(null, ['id', 'cn_name as text']);
	}
}

<?php

namespace App\Http\Controllers;

use App\Model\Worldcity;
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
	public function getcities(Request $request) {
		$q = $request->get('q');
		// $sql = DB::table('t_world_cities')
		// 	->select('cn_state', 'cn_name')
		// 	->where('cn_state', 'like', "%$q%")
		// 	->get();

		return Worldcity::where('cn_state', $q)->paginate(null, ['id', DB::Raw('cn_state as label, cn_name as text')]);
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

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Model\Country;
use Illuminate\Http\Request;

//
class CountryController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	//选项过多，可通过ajax方式动态分页载入选项
	public function getcountries() {

		return Country::paginate(null, ['id', 'cname as text']);
	}

	public function getcountrycities(Request $request) {
		$q = $request->get('q');
		return Country::where('cname', '=', $q)
			->paginate(null, ['id', 'cname as text']);
	}

	public function getcountrywithcities(Request $request) {
		$q = $request->get('q');
		$wcities = Country::
			with(['cities' => function ($query) {
			$query->select('id', 'cn_name as text', 'country_id');
		}])
			->select('id', 'cname')
			->get();
		return $this->transformer($wcities);
		// ->paginate();
	}

	protected function transformer($items) {
		$data = [];
		foreach ($items ?? [] as $item) {
			$data[] = [
				// 'id' => $item->id,
				'label' => $item->cname,
				// 'text' => $item->text,
				// 'country' => $item->country_id,
				'options' => $item->cities,
			];
		}
		return $data;
	}

	// 准备删除 resource
	public function getcitesbycountryresource() {
		// $q = $request->get('q');
		// return CountryResource::collection(Country::all())->toArray();
		return new CountryResource(Country::find(101));
	}
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;
use App\Model\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "index方法";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Country  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Country  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // 获取所有
    public function getCountries(){
        return CountryResource::collection(Country::paginate(null));
    }

    // 获取单个
    public function getCountry($id){
        return new CountryResource(Country::find($id));
    }

    // 获取通过上级获取所有
    public function getCountriesByContinent(Request $request)
    {
        $q = $request->get('q');
        $countries = new CountryCollection(Country::where('continent_id','=',$q)
            ->paginate(2));
        return $countries->withPath(url('api/v1/countries/getCountriesByContinent?q='.$q));
    }

    public function getCountryByName(Request $request) {
        $q = $request->get('q');
        $country =  Country::where('cname', '=', $q)
            ->paginate(null);
        return $country->withPath(url('api/v1/countries/getCountryByName?q='.$q));
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Continent;
use App\Model\Country;
use App\Http\Resources\ContinentResource;
use App\Http\Resources\ContinentCollection;
use App\Http\Resources\CountryCollection;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //返回集合
        return new ContinentCollection(Continent::paginate(null));
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
     * @param  \App\Model\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
        $continent = new ContinentResource(Continent::with('continentcountries')->findOrFail($id));
        // if (!$continent) {
        //     echo 'err message...';
        // }
        return response()->json($continent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Continent $continent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Continent $continent)
    {
        //
    }


    public function getCountries($id)
    {
        // 获取子类
        $countries = new CountryCollection(Country::where('continent_id','=',$id)->paginate(null));
        return response()->json($countries);
    }
}

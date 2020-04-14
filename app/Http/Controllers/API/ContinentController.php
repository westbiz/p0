<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Continent;
use App\Http\Resources\ContinentResource;
use App\Http\Resources\ContinentCollection;
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
        //
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
    public function show(Continent $continent)
    {
        //
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

    public function getContinents()
    {
        return new ContinentCollection(Continent::paginate(null));
    }

    public function getContinent($id)
    {
        return new ContinentResource(Continent::find($id));
    }
}

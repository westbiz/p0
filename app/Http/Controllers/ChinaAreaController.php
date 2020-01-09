<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ChinaArea;
use Illuminate\Support\Facades\DB;

class ChinaAreaController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getcitiesbyprovince(Request $request)
    {
        $q = $request->get('q');

        $regions = ChinaArea::where('areaName','like',"%$q%")
                            ->where('level',2)->get();
        $cities = ChinaArea::where('areaName','like',"%$q%")
                            ->where('level',3)->get();
        $provinces = ChinaArea::where('areaName','like',"%$q%")
                            ->where('parent_id', -1)->get();

        if ($regions->isNotEmpty()) {
            $data = DB::table('t_areas as p')
                        ->leftjoin('t_areas as a','p.id','=','a.parent_id')
                        ->select(['a.id', DB::Raw('concat(p.areaName," 》",a.areaName) as text')])
                        ->where('a.areaName','like',"%$q%")
                        // ->where('p.level',1)
                        // ->where('p.active','=',1)
                            ->paginate();
        } 

        elseif ($cities->isNotEmpty() ) {
            $data = DB::table('t_areas as a')
                        ->rightjoin('t_areas as p','a.parent_id','=','p.id')
                        ->select(['a.id', DB::Raw('concat(p.areaName," 》",a.areaName) as text')])
                        ->where('a.areaName','like',"%$q%")
                        // ->where('a.active','=',1)
                            ->paginate();
        }  
        else {
            $data = DB::table('t_areas as p')
                        ->rightjoin('t_areas as a','p.id','=','a.parent_id')
                        ->select(['a.id', DB::Raw('concat(p.areaName," 》",a.areaName) as text')])
                        ->where('p.areaName','like',"%$q%")
                        // ->where('p.active','=',1)
                            ->paginate();
        }
        
        // dd($citylike->isNotEmpty());
        // $data = ChinaArea::where('areaName','like',"%$q%")

        //         ->paginate(null, ['id', 'areaName as text']);
        return $data;
    }

}

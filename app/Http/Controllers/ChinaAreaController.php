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

        $prvlike = ChinaArea::where('areaName','like',"%$q%")
                            ->where('level',1)->get();

        $regionlike = ChinaArea::where('areaName','like',"%$q%")
                            ->where('level',2)->get();
        $citylike = ChinaArea::where('areaName','like',"%$q%")
                            ->where('level',3)->get();        
        if ($citylike->isNotEmpty()) {
            $data = DB::table('t_areas as a')
                        ->leftjoin('t_areas as p','a.parent_id','=','p.id')
                        ->select(['a.id', DB::Raw('concat(p.areaName," 》",a.areaName) as text')])
                        ->where('a.areaName','like',"%$q%")
                            ->paginate();
        } elseif ($regionlike->isNotEmpty()) {
            $data = ChinaArea::where('areaName','like',"%$q%")
                            ->paginate(null, ['id', 'areaName as text']);
        } else {
            $data = DB::table('t_areas as a')
                        ->rightjoin('t_areas as p','a.id','=','p.parent_id')
                        ->select(['p.id', DB::Raw('concat(a.areaName," 》",p.areaName) as text')])
                        ->where('a.areaName','like',"%$q%")
                            ->paginate();
        }
        
        // dd($citylike->isNotEmpty());
        // $data = ChinaArea::where('areaName','like',"%$q%")

        //         ->paginate(null, ['id', 'areaName as text']);
        return $data;
    }

}

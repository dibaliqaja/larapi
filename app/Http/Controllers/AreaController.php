<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Areas;
use App\Cities;
use App\Provinces;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area = Areas::paginate(10);
        $provinces = Provinces::all();
        $cities = Cities::all();
        return view('data_area.index', compact('area','provinces','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Provinces::all();
        $cities = Cities::all();
        return view('data_area.create', compact('provinces','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'province_code'   => 'required',
            'city_code'       => 'required',
            'area_code'     => 'required',
            'area_name'     => 'required|min:3|max:100'
        ]);

        Areas::create([
            'province_code'  => $request->province_code,
            'city_code'     => $request->city_code,
            'area_code'     => $request->area_code,
            'area_name'     => $request->area_name,
        ]);

        LogActivity::addToLog('Area Added');
        return redirect()->route('area.index')->with('success','Area Added');
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
        $this->validate($request, [
            'province_code'   => 'required',
            'city_code'       => 'required',
            'area_code'     => 'required',
            'area_name'     => 'required|min:3|max:100'
        ]);

        $area = Areas::findorfail($request->id);
        $area->update($request->all());

        LogActivity::addToLog('Area Updated');
        return redirect()->route('area.index')->with('success','Area Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Areas::find($id);
        $area->delete();

        LogActivity::addToLog('Area Deleted');
        return redirect()->back()->with('success','Area Deleted');
    }
}

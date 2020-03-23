<?php

namespace App\Http\Controllers;

use App\Cities;
use App\Helpers\LogActivity;
use App\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = Cities::paginate(10);
        $provinces = Provinces::all();
        return view('data_city.index', compact('city','provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Provinces::all();
        return view('data_city.create', compact('provinces'));
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
            'province_code'     => 'required',
            'city_code'     => 'required',
            'city_name'     => 'required|min:3|max:100'
        ]);

        Cities::create([
            'province_code'   => $request->province_code,
            'city_code'     => $request->city_code,
            'city_name'     => $request->city_name,
        ]);

        LogActivity::addToLog('City Added');
        return redirect()->route('city.index')->with('success','City Added');
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
            'city_code'     => 'required',
            'city_name'     => 'required|min:3|max:100'
        ]);

        $city = Cities::findorfail($request->id);
        $city->update($request->all());

        LogActivity::addToLog('City Updated');
        return redirect()->route('city.index')->with('success','City Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = Cities::find($id);
        $city->delete();

        LogActivity::addToLog('City Deleted');
        return redirect()->back()->with('success','City Deleted');
    }
}

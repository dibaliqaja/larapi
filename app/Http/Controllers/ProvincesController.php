<?php

namespace App\Http\Controllers;

use App\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvincesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $province = Provinces::paginate(10);
        return view('data_provinsi.index', compact('province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('data_provinsi.create');
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
            'province_name'     => 'required|min:3|max:100'
        ]);

        Provinces::create([
            'province_code'     => $request->province_code,
            'province_name'     => $request->province_name,
        ]);

        return redirect()->route('province.index')->with('success','Province Added');
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'province_code'     => 'required',
            'province_name'     => 'required|min:3|max:100'
        ]);

        $province = Provinces::findorfail($request->id);
        $province->update($request->all());
        return redirect()->route('province.index')->with('success','Province Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $province = Provinces::find($id);
        $province->delete();

        return redirect()->back()->with('success','Province Deleted');
    }
}

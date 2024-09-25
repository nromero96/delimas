<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;

class DistrictController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $districts = District::all();
        return view('district.index')->with('districts',$districts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        District::insert([    
            'name' => $request->get('name'),
        ]);

        return redirect('/districts');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $district = District::find($id);
        return view('district.edit')->with('district',$district);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        District::where('id', $id)
            ->update([
            'name' => $request->get('name'),
        ]);
        return redirect('/districts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $district = District::find($id);
        $district->delete();
        return redirect('/districts');
    }

}

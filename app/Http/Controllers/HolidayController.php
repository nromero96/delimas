<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = Holiday::all();
        return view('holiday.index')->with('holidays',$holidays);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $date = \DateTime::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d');

        $holidays = new Holiday();

        $holidays->date = $date;
        $holidays->name = $request->get('name');
        $holidays->note = $request->get('note');

        $holidays->save();

        return redirect('/holiday');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $holiday = Holiday::find($id);
        return view('holiday.edit')->with('holiday',$holiday);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $holiday = Holiday::find($id);;

        $date = \DateTime::createFromFormat('d-m-Y', $request->get('date'))->format('Y-m-d');

        $holiday->date = $date;
        $holiday->name = $request->get('name');
        $holiday->note = $request->get('note');

        $holiday->save();

        return redirect('/holiday');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $holiday = Holiday::find($id);
        $holiday->delete();
        return redirect('/holiday');
    }


    public function getlistholidays(Request $request){

        $holidays = Holiday::select('date')
                    ->get();
        return response(json_encode($holidays),200)->header('Content-type','text/plain');

    }
}

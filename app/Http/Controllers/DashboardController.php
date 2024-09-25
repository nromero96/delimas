<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

use App\Models\Period;
use App\Models\Periodday;

class DashboardController extends Controller
{

    public function index()
    {

        $datenow = Carbon::now()->format('Y-m-d');

        \DB::statement("SET SQL_MODE=''");

        $perioddays = Periodday::join('periods','periods.id','=','perioddays.id_period')
                                ->join('programprices','programprices.id','=','periods.id_programprice')
                                ->join('programs','programs.id','=','programprices.id_program')
                                ->select('programs.id AS programid', DB::raw('COUNT(programs.id) AS totalquantity'), 'programprices.color AS programcolor', 'programs.name AS programname', 'perioddays.date')
                                ->where('perioddays.date', $datenow)
                                ->groupBy('programs.id')
                                ->get();

        return view('dashboard')->with('perioddays',$perioddays);


    }

}

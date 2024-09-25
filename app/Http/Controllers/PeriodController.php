<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Program;
use App\Models\Programprice;
use App\Models\Customer;
use App\Models\Periodday;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use PDF;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $program = $request->get('filterbyprogram');
        $customer = $request->get('filterbycustomer');
        $filterbydate = $request->get('filterbydate');



        $periods = Period::join('programprices','programprices.id','=','periods.id_programprice')
                            ->join('programs','programs.id','=','programprices.id_program')
                            ->join('customers','customers.id','=','periods.id_customer')
                            ->where('programs.name','LIKE', "%$program%")
                            ->where('customers.name','LIKE', "%$customer%")
                            ->when($filterbydate, function ($query) use ($request) {
                                $query->where('periods.start_date', \DateTime::createFromFormat('d-m-Y', $request->filterbydate)->format('Y-m-d'));
                            })
                            ->orderBy('periods.id', 'desc')
                            ->paginate(20,['periods.*', 'programs.name AS programname','programprices.textcategoryprice','programprices.color AS programcolor', 'customers.name AS customername']);

                            return view('period.index')->with('periods',$periods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Programprice::leftJoin('programs','programprices.id_program', '=','programs.id')
                            ->orderBy('programs.name', 'ASC')
                            ->get(['programprices.*', 'programs.id AS programid','programs.name AS programname']);


        $customers = Customer::all();

        return view('period.create')->with('programs',$programs)->with('customers',$customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $formatstartdate = \DateTime::createFromFormat('d-m-Y', $request->get('startdate'))->format('Y-m-d');

        $lastlistdates = $request->get('listdate');
        foreach ($lastlistdates as $element) {
            if(!next($lastlistdates)) {
                $formatenddate = $element;
            }
        }

        $period_id = Period::insertGetId([

            'id_programprice' => $request->get('idprogram'),
            'id_customer' => $request->get('idcustomer'),
            'start_date' => $formatstartdate,
            'end_date' => $formatenddate,
            'number_of_days' => $request->get('numberofdays'),
            'quantity_of_menu' => $request->get('valquantitymenu'),
            'unitprice_moment' => $request->get('valunitprice'),
            'total_price' => $request->get('valtotalprice'),
            'status' => 'Activo',
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),

        ]);


        foreach($request->get('listdayname') as $key => $value){
                $data = array(
                            'id_period'=>$period_id,
                            'dayname'=>$request->get('listdayname') [$key],
                            'date'=> $request->get('listdate') [$key],
                            'quantity'=>$request->get('listcantidad') [$key],
                );
                Periodday::insert($data);
        }

        return redirect('/period');



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

        $programs = Programprice::leftJoin('programs','programprices.id_program', '=','programs.id')
                            ->orderBy('programs.name', 'ASC')
                            ->get(['programprices.*', 'programs.id AS programid','programs.name AS programname']);

        $period = Period::find($id);
        $customer = Customer::find($period->id_customer);

        $perioddays = Periodday::where('id_period', $id)->get();

        return view('period.edit')->with('programs',$programs)->with('period',$period)->with('customer',$customer)->with('perioddays',$perioddays);
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

        $formatstartdate = \DateTime::createFromFormat('d-m-Y', $request->get('startdate'))->format('Y-m-d');
        $lastlistdates = $request->get('listdate');
        foreach ($lastlistdates as $element) {
            if(!next($lastlistdates)) {
                $formatenddate = $element;
            }
        }

        $period = Period::find($id);
        $period->id_programprice = $request->get('idprogram');
        $period->start_date = $formatstartdate;
        $period->end_date = $formatenddate;
        $period->number_of_days = $request->get('numberofdays');
        $period->quantity_of_menu = $request->get('valquantitymenu');
        $period->unitprice_moment = $request->get('valunitprice');
        $period->total_price = $request->get('valtotalprice');
        $period->status = 'Activo';
        $period->updated_at = date("Y-m-d H:i:s", strtotime('now'));

        $period->save();

            $data = Periodday::leftJoin('periods','perioddays.id_period', '=','periods.id')
                            ->where('id_period', $id);
                            $data->delete();

            foreach($request->get('listdayname') as $key => $value){
                $data = array(
                            'id_period'=>$id,
                            'dayname'=>$request->get('listdayname') [$key],
                            'date'=> $request->get('listdate') [$key],
                            'quantity'=>$request->get('listcantidad') [$key],
                );
                Periodday::insert($data);
            }

        return redirect('period');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $data = Periodday::leftJoin('periods','perioddays.id_period', '=','periods.id')
                            ->where('id_period', $id);
        Period::where('id', $id)->delete();
        $data->delete();

        return redirect('/period');

    }


    public function deliveriesoftheday(Request $request)
    {

        $program = $request->get('filterbyprogram');
        $customer = $request->get('filterbycustomer');
        $date = $request->get('filterbydate');

        if($date == ''){
            $datefilter = Carbon::now()->format('Y-m-d');
        }else{
            $datefilter = \DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }

        $perioddays = Periodday::join('periods','periods.id','=','perioddays.id_period')

                                ->join('programprices','programprices.id','=','periods.id_programprice')
                                ->join('programs','programs.id','=','programprices.id_program')

                                ->join('customers','customers.id','=','periods.id_customer')
                                ->where('programs.name','LIKE', "%$program%")
                                ->where('customers.name','LIKE', "%$customer%")
                                ->where('perioddays.date', $datefilter)
                                ->orderBy('programs.name', 'ASC')
                                ->orderBy('customers.name', 'ASC')
                                ->paginate(20,['perioddays.*' , 'periods.id AS periodsid', 'programs.name AS programname','programprices.textcategoryprice AS textcategoryprice','programprices.color AS programcolor', 'customers.id AS customerid', 'customers.name AS customername']);

        return view('period.deliveriesoftheday')->with('perioddays',$perioddays);

    }

    // Print list Stickers
    public function downloadStickers(Request $request){

        $program = $request->get('filterbyprogram');
        $customer = $request->get('filterbycustomer');
        $date = $request->get('filterbydate');

        if($date == ''){
            $datefilter = Carbon::now()->format('Y-m-d');
        }else{
            $datefilter = \DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }

        $perioddays = Periodday::join('periods','periods.id','=','perioddays.id_period')
                                ->join('programprices','programprices.id','=','periods.id_programprice')
                                ->join('programs','programs.id','=','programprices.id_program')
                                ->join('customers','customers.id','=','periods.id_customer')
                                ->where('programs.name','LIKE', "%$program%")
                                ->where('customers.name','LIKE', "%$customer%")
                                ->where('perioddays.date', $datefilter)
                                ->orderBy('programs.name', 'ASC')
                                ->orderBy('customers.name', 'ASC')
                                ->get(['programs.name AS programname', 'programprices.textcategoryprice AS textcategoryprice', 'customers.name AS customername', 'customers.district AS customerdistrict']);

        view()->share('period.stickers',$perioddays);

        $pdf = PDF::loadView('period.stickers', ['perioddays' => $perioddays]);
        //return $pdf->download('Lista de Stickers.pdf');
        return $pdf->stream();

    }


    // Print list entry control
    public function downloadEntryControl(Request $request){

        $program = $request->get('filterbyprogram');
        $customer = $request->get('filterbycustomer');
        $date = $request->get('filterbydate');

        if($date == ''){
            $datefilter = Carbon::now()->format('Y-m-d');
        }else{
            $datefilter = \DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }

        $perioddays = Periodday::join('periods','periods.id','=','perioddays.id_period')
                                ->join('programprices','programprices.id','=','periods.id_programprice')
                                ->join('programs','programs.id','=','programprices.id_program')
                                ->join('customers','customers.id','=','periods.id_customer')
                                ->where('programs.name','LIKE', "%$program%")
                                ->where('customers.name','LIKE', "%$customer%")
                                ->where('perioddays.date', $datefilter)
                                ->orderBy('programs.name', 'ASC')
                                ->orderBy('customers.name', 'ASC')
                                ->get(['programs.name AS programname', 'programprices.textcategoryprice AS textcategoryprice' ,'customers.name AS customername', 'customers.address AS customeraddress', 'customers.district AS customerdistrict', 'customers.phone AS customerphone']);

        view()->share('period.entrycontrol',$perioddays);

        $pdf = PDF::loadView('period.entrycontrol', ['perioddays' => $perioddays]);
        //return $pdf->download('Lista de Stickers.pdf');
        return $pdf->stream();

    }


}

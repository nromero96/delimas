<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Programprice;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $programs = Program::all();
        return view('program.index')->with('programs',$programs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $program_id = Program::insertGetId([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);


        foreach($request->get('textcategoryprice') as $key => $value){
                $data = array(
                            'id_program'=>$program_id,
                            'textcategoryprice'=>$request->get('textcategoryprice') [$key],
                            'color'=>$request->get('color') [$key],
                            'oneprice'=> $request->get('oneprice') [$key],
                            'fiveprice'=>$request->get('fiveprice') [$key],
                            'tenprice'=>$request->get('tenprice') [$key],
                            'twentyprice'=>$request->get('twentyprice') [$key],
                );
                Programprice::insert($data);
        }

        return redirect('/program');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $program = Program::find($id);
        $programprices = Programprice::where('id_program', $id)->get();
        return view('program.edit')->with('program',$program)->with('programprices',$programprices);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $program = Program::find($id);
        $program->name = $request->get('name');
        $program->status = $request->get('status');
        $program->updated_at = date("Y-m-d H:i:s", strtotime('now'));

        $program->save();

            // $data = Programprice::leftJoin('Programs','Programprices.id_program', '=','Programs.id')
            //                     ->where('id_program', $id);
            //                     $data->delete();

            foreach($request->get('textcategoryprice') as $key => $value){
                $idprogramprice = $request->get('idprogramprice') [$key];
                if($idprogramprice == 'new'){
                    $data = array(
                        'id_program'=>$id,
                        'textcategoryprice'=>$request->get('textcategoryprice') [$key],
                        'color'=>$request->get('color') [$key],
                        'oneprice'=> $request->get('oneprice') [$key],
                        'fiveprice'=>$request->get('fiveprice') [$key],
                        'tenprice'=>$request->get('tenprice') [$key],
                        'twentyprice'=>$request->get('twentyprice') [$key],
                    );
                    Programprice::insert($data);
                }else{
                    $data = array(
                        'textcategoryprice'=>$request->get('textcategoryprice') [$key],
                        'color'=>$request->get('color') [$key],
                        'oneprice'=> $request->get('oneprice') [$key],
                        'fiveprice'=>$request->get('fiveprice') [$key],
                        'tenprice'=>$request->get('tenprice') [$key],
                        'twentyprice'=>$request->get('twentyprice') [$key],
                    );
                    Programprice::where('id', $idprogramprice)->update($data);
                }
            }
        return redirect('/program');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $data = Programprice::leftJoin('programs','programprices.id_program', '=','programs.id')
                                ->where('id_program', $id);
        Program::where('id', $id)->delete();
        $data->delete();
        return redirect('/program');

    }


    public function destroysingleprogramprice($id)
    {
        $programprice = Programprice::find($id);
        $programprice->delete();

        return response()->json([
            'message' => 'success'
            ]);

        //return response()->json($customer);
        //return redirect('/holiday');

    }

}

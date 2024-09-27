<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planrequest;

class PlanrequestController extends Controller
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
        //valida los campos del formulario
        $request->validate([
            'address' => 'required',
            'product' => 'required',
            'plan' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'payment' => 'required',
            'voucher' => 'required',
        ]);

        //crea un nuevo pedido
        $planrequest = new Planrequest;
        $planrequest->address = $request->address;
        $planrequest->product = $request->product;
        $planrequest->plan = $request->plan;
        $planrequest->name = $request->name;
        $planrequest->phone = $request->phone;
        $planrequest->payment = $request->payment;
        $planrequest->voucher = $request->voucher;
        $planrequest->status = 'Pendiente';
        $planrequest->save();

        //devuelve a la vista anterior con un mensaje success
        return back()->with('success', 'Pedido creado correctamente. Nos pondremos en contacto contigo en breve.');
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
}

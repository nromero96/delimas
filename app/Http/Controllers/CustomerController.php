<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\District;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $numdoc = $request->get('filterbynumdoc');
        $name = $request->get('filterbyname');
        $district = $request->get('filterbydate');


        $customers = Customer::where('customers.document_number','LIKE', "%$numdoc%")
                                ->where('customers.name','LIKE', "%$name%")
                                ->where('customers.district','LIKE', "%$district%")
                                ->orderBy('customers.name', 'ASC')
                                ->paginate(20);

        return view('customer.index')->with('customers',$customers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $districts = District::all();

        return view('customer.create')->with('districts',$districts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customers = new Customer();

        $customers->document_type = $request->get('documenttype');
        $customers->document_number = $request->get('documentnumber');
        $customers->name = $request->get('name');
        $customers->address = $request->get('address');
        $customers->district = $request->get('district');
        $customers->phone = $request->get('phone');
        $customers->email = $request->get('email');
        $customers->restriction = $request->get('restriction');
        $customers->recommendation = $request->get('recommendation');
        $customers->status = $request->get('status');

        $customers->save();

        return redirect('/customer');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $districts = District::all();

        $customer = Customer::find($id);
        return view('customer.edit')->with('customer',$customer)->with('districts',$districts);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        $customer->document_type = $request->get('documenttype');
        $customer->document_number = $request->get('documentnumber');
        $customer->name = $request->get('name');
        $customer->address = $request->get('address');
        $customer->district = $request->get('district');
        $customer->phone = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->restriction = $request->get('restriction');
        $customer->recommendation = $request->get('recommendation');
        $customer->status = $request->get('status');

        $customer->save();

        return redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect('/customer'); 
    }


    /* View information customer by id format JSON */
    public function showinfocustomer($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


}

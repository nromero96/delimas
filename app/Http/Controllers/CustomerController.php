<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\District;
use App\Models\Period;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        $documentNumber = trim((string) $request->query('filterbynumdoc', ''));
        $name = trim((string) $request->query('filterbyname', ''));
        $district = trim((string) $request->query('filterbydistrict', ''));

        if ($documentNumber !== '') {
            $query->where('customers.document_number', 'LIKE', '%' . $documentNumber . '%');
        }

        if ($name !== '') {
            $query->where('customers.name', 'LIKE', '%' . $name . '%');
        }

        if ($district !== '') {
            $query->where('customers.district', 'LIKE', '%' . $district . '%');
        }

        $customers = $query->orderBy('customers.name', 'ASC')
            ->paginate(20)
            ->withQueryString();

        return view('customer.index', compact('customers'));
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
        $customer = Customer::create($this->validatedCustomerData($request));

        if ($request->input('next') === 'period') {
            return redirect()->route('period.create', ['customer_id' => $customer->id])
                ->with('success', 'Cliente creado. Complete los datos de su período.');
        }

        //Retornar con mensaje success
        return redirect('/customer')->with('success', 'Cliente creado correctamente');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $districts = District::all();

        $customer = Customer::findOrFail($id);
        $activePeriodsCount = Period::where('id_customer', $customer->id)
            ->where('status', 'Activo')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->count();

        return view('customer.edit', compact('customer', 'districts', 'activePeriodsCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($this->validatedCustomerData($request, $customer));

        return redirect('/customer')->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = 'Inactivo';
        $customer->save();
        $customer->delete();
        return redirect('/customer')->with('success', 'Cliente ocultado correctamente.');
    }

    public function block(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'period_action' => ['required', Rule::in(['keep', 'suspend'])],
        ]);

        DB::transaction(function () use ($customer, $validated) {
            $customer->update(['status' => 'Bloqueado']);

            if ($validated['period_action'] === 'suspend') {
                Period::where('id_customer', $customer->id)
                    ->where('status', 'Activo')
                    ->whereDate('end_date', '>=', now()->toDateString())
                    ->update(['status' => 'Suspendido']);
            }
        });

        $message = $validated['period_action'] === 'suspend'
            ? 'Cliente bloqueado y períodos vigentes suspendidos.'
            : 'Cliente bloqueado. Sus períodos vigentes se mantuvieron activos.';

        return redirect()->route('customer.index')->with('success', $message);
    }

    public function unblock(Customer $customer)
    {
        $customer->update(['status' => 'Activo']);

        return redirect()->route('customer.edit', $customer)->with('success', 'Cliente desbloqueado correctamente.');
    }


    /* View information customer by id format JSON */
    public function showinfocustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    private function validatedCustomerData(Request $request, ?Customer $customer = null): array
    {
        $uniqueDocumentNumber = Rule::unique('customers', 'document_number');
        if ($customer) {
            $uniqueDocumentNumber->ignore($customer->id);
        }

        $documentNumberRule = $request->input('documenttype') === 'DNI'
            ? ['required', 'regex:/^\d{8}$/', $uniqueDocumentNumber]
            : ['required', 'regex:/^[A-Za-z0-9]{5,20}$/', $uniqueDocumentNumber];

        $validated = $request->validate([
            'documenttype' => ['required', Rule::in(['DNI', 'CARNET EXT.', 'OTROS'])],
            'documentnumber' => $documentNumberRule,
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:50', Rule::exists('districts', 'name')],
            'address_reference' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\+?[0-9]{7,19}$/'],
            'phone_two' => ['nullable', 'regex:/^\+?[0-9]{7,19}$/'],
            'email' => ['nullable', 'email', 'max:192'],
            'restriction' => ['nullable', 'string', 'max:2000'],
            'recommendation' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in($customer && $customer->status === 'Bloqueado'
                ? ['Bloqueado']
                : ['Activo', 'Inactivo', 'Suspendido'])],
        ], [
            'documentnumber.unique' => 'El número de documento ya está registrado para otro cliente.',
        ]);

        return [
            'document_type' => $validated['documenttype'] ?? null,
            'document_number' => $validated['documentnumber'] ?? null,
            'name' => $validated['name'],
            'address' => $validated['address'],
            'district' => $validated['district'],
            'address_reference' => $validated['address_reference'] ?? null,
            'phone' => $validated['phone'],
            'phone_two' => $validated['phone_two'] ?? null,
            'email' => $validated['email'] ?? null,
            'restriction' => $validated['restriction'] ?? null,
            'recommendation' => $validated['recommendation'] ?? null,
            'status' => $validated['status'],
        ];
    }


}

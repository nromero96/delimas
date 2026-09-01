<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Program;
use App\Models\Programprice;
use App\Models\Customer;
use App\Models\Periodday;
use App\Models\Holiday;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
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
        $validated = $request->validate([
            'filterbydate' => ['nullable', 'date_format:d-m-Y'],
            'filterbystatus' => ['nullable', Rule::in(['vigente', 'proximo', 'vencido', 'suspendido'])],
        ]);
        $program = trim((string) $request->query('filterbyprogram', ''));
        $customer = trim((string) $request->query('filterbycustomer', ''));
        $status = $validated['filterbystatus'] ?? '';
        $today = Carbon::today()->format('Y-m-d');

        $query = Period::join('programprices', 'programprices.id', '=', 'periods.id_programprice')
            ->join('programs', 'programs.id', '=', 'programprices.id_program')
            ->join('customers', 'customers.id', '=', 'periods.id_customer')
            ->where('periods.status', '!=', 'Oculto')
            ->when($program !== '', function ($query) use ($program) {
                $query->where('programs.name', 'LIKE', '%' . $program . '%');
            })
            ->when($customer !== '', function ($query) use ($customer) {
                $query->where(function ($subquery) use ($customer) {
                    $subquery->where('customers.name', 'LIKE', '%' . $customer . '%')
                        ->orWhere('customers.document_number', 'LIKE', '%' . $customer . '%');
                });
            })
            ->when(!empty($validated['filterbydate']), function ($query) use ($validated) {
                $date = Carbon::createFromFormat('d-m-Y', $validated['filterbydate'])->format('Y-m-d');
                $query->whereDate('periods.start_date', $date);
            })
            ->when($status === 'vigente', function ($query) use ($today) {
                $query->where('periods.status', 'Activo')->whereDate('periods.start_date', '<=', $today)->whereDate('periods.end_date', '>=', $today);
            })
            ->when($status === 'proximo', function ($query) use ($today) {
                $query->where('periods.status', 'Activo')->whereDate('periods.start_date', '>', $today);
            })
            ->when($status === 'vencido', function ($query) use ($today) {
                $query->whereDate('periods.end_date', '<', $today);
            })
            ->when($status === 'suspendido', function ($query) {
                $query->where('periods.status', 'Suspendido');
            })
            ->select([
                'periods.*',
                'programs.name as programname',
                'programprices.textcategoryprice',
                'programprices.color as programcolor',
                'customers.name as customername',
                'customers.document_number as customerdocument',
            ])
            ->selectSub(function ($query) use ($today) {
                $query->from('perioddays')
                    ->selectRaw('COALESCE(SUM(quantity), 0)')
                    ->whereColumn('perioddays.id_period', 'periods.id')
                    ->whereDate('perioddays.date', '<', $today);
            }, 'elapsed_deliveries')
            ->selectSub(function ($query) use ($today) {
                $query->from('perioddays')
                    ->selectRaw('COALESCE(SUM(quantity), 0)')
                    ->whereColumn('perioddays.id_period', 'periods.id')
                    ->whereDate('perioddays.date', '>=', $today);
            }, 'remaining_deliveries');

        $periods = $query->orderByDesc('periods.id')->paginate(20)->withQueryString();

        return view('period.index', compact('periods'));
    }

    public function renewals(Request $request)
    {
        $program = trim((string) $request->query('filterbyprogram', ''));
        $customer = trim((string) $request->query('filterbycustomer', ''));

        $periods = Period::from('periods as expired_periods')
            ->join('programprices', 'programprices.id', '=', 'expired_periods.id_programprice')
            ->join('programs', 'programs.id', '=', 'programprices.id_program')
            ->join('customers', 'customers.id', '=', 'expired_periods.id_customer')
            ->whereDate('expired_periods.end_date', '<', Carbon::today())
            ->where('expired_periods.status', '!=', 'Oculto')
            ->whereNull('customers.deleted_at')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('periods as current_periods')
                    ->whereColumn('current_periods.id_customer', 'expired_periods.id_customer')
                    ->whereColumn('current_periods.id_programprice', 'expired_periods.id_programprice')
                    ->where('current_periods.status', 'Activo')
                    ->whereDate('current_periods.end_date', '>=', Carbon::today());
            })
            ->when($program !== '', function ($query) use ($program) {
                $query->where('programs.name', 'LIKE', '%' . $program . '%');
            })
            ->when($customer !== '', function ($query) use ($customer) {
                $query->where(function ($subquery) use ($customer) {
                    $subquery->where('customers.name', 'LIKE', '%' . $customer . '%')
                        ->orWhere('customers.document_number', 'LIKE', '%' . $customer . '%');
                });
            })
            ->orderByDesc('expired_periods.end_date')
            ->paginate(20, [
                'expired_periods.*',
                'programs.name as programname',
                'programprices.textcategoryprice',
                'programprices.color as programcolor',
                'customers.name as customername',
                'customers.document_number as customerdocument',
            ])
            ->withQueryString();

        return view('period.renewals', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $programs = Programprice::leftJoin('programs','programprices.id_program', '=','programs.id')
                            ->orderBy('programs.name', 'ASC')
                            ->get(['programprices.*', 'programs.id AS programid','programs.name AS programname']);


        $customers = Customer::orderBy('name')->get();
        $selectedCustomerId = (int) $request->query('customer_id');
        if ($selectedCustomerId && !$customers->contains('id', $selectedCustomerId)) {
            $selectedCustomerId = 0;
        }
        $selectedProgramPriceId = (int) $request->query('programprice_id');
        if ($selectedProgramPriceId && !$programs->contains('id', $selectedProgramPriceId)) {
            $selectedProgramPriceId = 0;
        }
        $holidays = Holiday::pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->values();

        return view('period.create', compact('programs', 'customers', 'selectedCustomerId', 'selectedProgramPriceId', 'holidays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idprogram' => ['required', 'integer', 'exists:programprices,id'],
            'idcustomer' => ['required', 'integer', 'exists:customers,id'],
            'startdate' => ['required', 'date_format:d-m-Y'],
            'numberofdays' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $startDate = Carbon::createFromFormat('d-m-Y', $validated['startdate'])->startOfDay();
        if ($startDate->lt(Carbon::today())) {
            throw ValidationException::withMessages(['startdate' => 'La fecha de inicio no puede estar en el pasado.']);
        }

        $holidayDates = Holiday::pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->all();

        if ($startDate->isWeekend() || in_array($startDate->format('Y-m-d'), $holidayDates, true)) {
            throw ValidationException::withMessages(['startdate' => 'La fecha de inicio debe ser un día laborable.']);
        }

        $periodDays = $this->buildPeriodDays($startDate, (int) $validated['numberofdays'], $holidayDates);
        $conflictingPeriod = $this->findConflictingPeriod(
            (int) $validated['idcustomer'],
            (int) $validated['idprogram'],
            $startDate,
            Carbon::parse(end($periodDays)['date'])
        );
        if ($conflictingPeriod) {
            throw ValidationException::withMessages([
                'startdate' => 'El cliente ya tiene un período activo para este programa que coincide con las fechas seleccionadas.',
            ]);
        }

        $programPrice = Programprice::findOrFail($validated['idprogram']);
        $quantity = count($periodDays);
        $unitPrice = $this->unitPriceForQuantity($programPrice, $quantity);
        $totalPrice = round($unitPrice * $quantity, 2);

        DB::transaction(function () use ($validated, $startDate, $periodDays, $quantity, $unitPrice, $totalPrice) {
            $period = Period::create([
                'id_programprice' => $validated['idprogram'],
                'id_customer' => $validated['idcustomer'],
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => end($periodDays)['date'],
                'number_of_days' => (int) $validated['numberofdays'],
                'quantity_of_menu' => $quantity,
                'unitprice_moment' => $unitPrice,
                'total_price' => $totalPrice,
                'status' => 'Activo',
            ]);

            foreach ($periodDays as &$day) {
                $day['id_period'] = $period->id;
            }
            unset($day);
            Periodday::insert($periodDays);
        });

        return redirect('/period')->with('success', 'Período creado correctamente.');
    }

    private function buildPeriodDays(Carbon $startDate, int $numberOfDays, array $holidayDates): array
    {
        $days = [];
        $date = $startDate->copy();

        while (count($days) < $numberOfDays) {
            $formattedDate = $date->format('Y-m-d');
            if (!$date->isWeekend() && !in_array($formattedDate, $holidayDates, true)) {
                $days[] = [
                    'dayname' => ucfirst($date->locale('es')->dayName),
                    'date' => $formattedDate,
                    'quantity' => 1,
                ];
            }
            $date->addDay();
        }

        return $days;
    }

    private function unitPriceForQuantity(Programprice $price, int $quantity): float
    {
        if ($quantity >= 30) {
            return round((float) $price->thirtyprice / 30, 2);
        }
        if ($quantity >= 20) {
            return round((float) $price->twentyprice / 20, 2);
        }
        if ($quantity >= 10) {
            return round((float) $price->tenprice / 10, 2);
        }
        if ($quantity >= 5) {
            return round((float) $price->fiveprice / 5, 2);
        }

        return round((float) $price->oneprice, 2);
    }

    private function buildPeriodDaysWithQuantities(Carbon $startDate, array $quantities, array $holidayDates): array
    {
        $days = [];
        $date = $startDate->copy();

        foreach ($quantities as $quantity) {
            while ($date->isWeekend() || in_array($date->format('Y-m-d'), $holidayDates, true)) {
                $date->addDay();
            }
            $days[] = [
                'dayname' => ucfirst($date->locale('es')->dayName),
                'date' => $date->format('Y-m-d'),
                'quantity' => $quantity,
            ];
            $date->addDay();
        }

        return $days;
    }

    private function findConflictingPeriod(int $customerId, int $programPriceId, Carbon $startDate, Carbon $endDate): ?Period
    {
        return Period::where('id_customer', $customerId)
            ->where('id_programprice', $programPriceId)
            ->where('status', 'Activo')
            ->whereDate('start_date', '<=', $endDate->format('Y-m-d'))
            ->whereDate('end_date', '>=', $startDate->format('Y-m-d'))
            ->orderBy('start_date')
            ->first();
    }

    public function checkConflict(Request $request)
    {
        $validated = $request->validate([
            'idprogram' => ['required', 'integer', 'exists:programprices,id'],
            'idcustomer' => ['required', 'integer', 'exists:customers,id'],
            'startdate' => ['required', 'date_format:d-m-Y'],
            'numberofdays' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $startDate = Carbon::createFromFormat('d-m-Y', $validated['startdate'])->startOfDay();
        $holidayDates = Holiday::pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->all();
        $periodDays = $this->buildPeriodDays($startDate, (int) $validated['numberofdays'], $holidayDates);
        $endDate = Carbon::parse(end($periodDays)['date']);
        $period = $this->findConflictingPeriod(
            (int) $validated['idcustomer'],
            (int) $validated['idprogram'],
            $startDate,
            $endDate
        );

        return response()->json([
            'conflict' => (bool) $period,
            'message' => $period
                ? 'Ya existe un período activo para este cliente y programa, desde '
                    . Carbon::parse($period->start_date)->format('d-m-Y') . ' hasta '
                    . Carbon::parse($period->end_date)->format('d-m-Y') . '.'
                : null,
        ]);
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
        $validated = $request->validate([
            'idprogram' => ['required', 'integer', 'exists:programprices,id'],
            'startdate' => ['required', 'date_format:d-m-Y'],
            'numberofdays' => ['required', 'integer', 'min:1', 'max:365'],
            'listcantidad' => ['required', 'array', 'min:1', 'max:730'],
            'listcantidad.*' => ['required', 'integer', 'in:0,1'],
        ]);

        $period = Period::findOrFail($id);
        $startDate = Carbon::createFromFormat('d-m-Y', $validated['startdate'])->startOfDay();
        $holidayDates = Holiday::pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->all();

        if ($startDate->isWeekend() || in_array($startDate->format('Y-m-d'), $holidayDates, true)) {
            throw ValidationException::withMessages(['startdate' => 'La fecha de inicio debe ser un día laborable.']);
        }

        $quantities = array_map('intval', $validated['listcantidad']);
        if (array_sum($quantities) !== (int) $validated['numberofdays'] || end($quantities) !== 1) {
            throw ValidationException::withMessages([
                'numberofdays' => 'La programación diaria no coincide con la cantidad de días del período.',
            ]);
        }

        $periodDays = $this->buildPeriodDaysWithQuantities($startDate, $quantities, $holidayDates);
        $quantity = array_sum($quantities);
        $unitPrice = $this->unitPriceForQuantity(Programprice::findOrFail($validated['idprogram']), $quantity);

        DB::transaction(function () use ($period, $validated, $startDate, $periodDays, $quantity, $unitPrice) {
            $period->update([
                'id_programprice' => $validated['idprogram'],
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => end($periodDays)['date'],
                'number_of_days' => (int) $validated['numberofdays'],
                'quantity_of_menu' => $quantity,
                'unitprice_moment' => $unitPrice,
                'total_price' => round($unitPrice * $quantity, 2),
                'status' => 'Activo',
            ]);

            Periodday::where('id_period', $period->id)->delete();
            foreach ($periodDays as &$day) {
                $day['id_period'] = $period->id;
            }
            unset($day);
            Periodday::insert($periodDays);
        });

        return redirect('period')->with('success', 'Período actualizado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $period = Period::findOrFail($id);
        $period->update(['status' => 'Oculto']);

        return redirect('/period')->with('success', 'Período ocultado correctamente.');

    }


    public function deliveriesoftheday(Request $request)
    {
        $datefilter = $this->validatedDeliveryDate($request);
        $perioddays = $this->deliveryQuery($request, $datefilter)
            ->orderBy('customers.district')
            ->orderBy('customers.address')
            ->orderBy('customers.name')
            ->paginate(20, [
                'perioddays.*',
                'periods.id as periodsid',
                'programs.name as programname',
                'programprices.textcategoryprice',
                'programprices.color as programcolor',
                'customers.id as customerid',
                'customers.name as customername',
                'customers.document_number as customerdocument',
                'customers.address as customeraddress',
                'customers.district as customerdistrict',
                'customers.address_reference as customeraddressreference',
                'customers.phone as customerphone',
            ])
            ->withQueryString();

        return view('period.deliveriesoftheday', compact('perioddays', 'datefilter'));

    }

    // Print list Stickers
    public function downloadStickers(Request $request){
        $datefilter = $this->validatedDeliveryDate($request);
        $perioddays = $this->deliveryQuery($request, $datefilter)
                                ->orderBy('programs.name', 'ASC')
                                ->orderBy('customers.name', 'ASC')
                                ->get([
                                    'programs.name as programname',
                                    'programprices.textcategoryprice',
                                    'programprices.color as programcolor',
                                    'customers.name as customername',
                                    'customers.document_number as customerdocument',
                                    'customers.address as customeraddress',
                                    'customers.district as customerdistrict',
                                    'customers.address_reference as customeraddressreference',
                                    'customers.phone as customerphone',
                                    'perioddays.date as perioddate',
                                    'perioddays.quantity as periodquantity',
                                ]);

        view()->share('period.stickers',$perioddays);

        $pdf = PDF::loadView('period.stickers', ['perioddays' => $perioddays])
            ->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'isRemoteEnabled' => false]);
        //return $pdf->download('Lista de Stickers.pdf');
        return $pdf->stream();

    }


    // Print list entry control
    public function downloadEntryControl(Request $request){
        $datefilter = $this->validatedDeliveryDate($request);
        $perioddays = $this->deliveryQuery($request, $datefilter)
                                ->orderBy('programs.name', 'ASC')
                                ->orderBy('customers.name', 'ASC')
                                ->get([
                                    'programs.name as programname',
                                    'programprices.textcategoryprice',
                                    'customers.name as customername',
                                    'customers.document_number as customerdocument',
                                    'customers.address as customeraddress',
                                    'customers.district as customerdistrict',
                                    'customers.phone as customerphone',
                                    'customers.address_reference as customeraddressreference',
                                    'perioddays.date as perioddate',
                                    'perioddays.quantity as periodquantity',
                                ]);

        view()->share('period.entrycontrol',$perioddays);

        $pdf = PDF::loadView('period.entrycontrol', ['perioddays' => $perioddays])
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 150, 'isRemoteEnabled' => false]);
        //return $pdf->download('Lista de Stickers.pdf');
        return $pdf->stream();

    }

    private function validatedDeliveryDate(Request $request): string
    {
        $date = trim((string) $request->query('filterbydate', ''));
        if ($date === '') {
            return Carbon::today()->format('Y-m-d');
        }

        try {
            $parsedDate = Carbon::createFromFormat('d-m-Y', $date);
            if ($parsedDate->format('d-m-Y') !== $date) {
                throw new \InvalidArgumentException();
            }
            return $parsedDate->format('Y-m-d');
        } catch (\Throwable $exception) {
            session()->flash('delivery_filter_error', 'La fecha debe tener el formato día-mes-año. Se muestran las entregas de hoy.');
            return Carbon::today()->format('Y-m-d');
        }
    }

    private function deliveryQuery(Request $request, string $datefilter)
    {
        $program = trim((string) $request->query('filterbyprogram', ''));
        $customer = trim((string) $request->query('filterbycustomer', ''));

        return Periodday::join('periods', 'periods.id', '=', 'perioddays.id_period')
            ->join('programprices', 'programprices.id', '=', 'periods.id_programprice')
            ->join('programs', 'programs.id', '=', 'programprices.id_program')
            ->join('customers', 'customers.id', '=', 'periods.id_customer')
            ->where('periods.status', 'Activo')
            ->whereNull('customers.deleted_at')
            ->where('perioddays.quantity', '>', 0)
            ->whereDate('perioddays.date', $datefilter)
            ->when($program !== '', function ($query) use ($program) {
                $query->where('programs.name', 'LIKE', '%' . $program . '%');
            })
            ->when($customer !== '', function ($query) use ($customer) {
                $query->where(function ($subquery) use ($customer) {
                    $subquery->where('customers.name', 'LIKE', '%' . $customer . '%')
                        ->orWhere('customers.document_number', 'LIKE', '%' . $customer . '%');
                });
            });
    }


}

@extends('layouts.maintemplate')

@section('title', 'Periodos')

@section('buttonsarea')
<a href="{{  url('deliveriesoftheday') }}" class="btn btn-secondary mx-2" role="button"><i class="bi bi-list"></i> Entregas del día</a>
    <a href="{{  url('period/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">
    @if (session('success'))
        <div class="col-12"><div class="alert alert-success" role="alert">{{ session('success') }}</div></div>
    @endif
    @if ($errors->any())
        <div class="col-12"><div class="alert alert-danger" role="alert">La fecha del filtro debe tener el formato día-mes-año.</div></div>
    @endif

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">
                <h5 class="me-auto">Lista de periodos</h5>
                <div>
                    <form action="{{ route('period.index') }}" method="GET" class="d-flex flex-wrap gap-2 justify-content-end">
                        <input type="search" name="filterbyprogram" class="form-control w-auto" value="{{ request('filterbyprogram') }}" placeholder="Programa...">
                        <input type="search" name="filterbycustomer" class="form-control w-auto" value="{{ request('filterbycustomer') }}" placeholder="Cliente o documento...">
                        <input type="text" name="filterbydate" id="inputsearchdatestart" value="{{ request('filterbydate') }}" autocomplete="off" class="form-control w-auto" placeholder="Fecha inicio...">
                        <select name="filterbystatus" class="form-select w-auto">
                            <option value="">Todos los estados</option>
                            <option value="vigente" {{ request('filterbystatus') === 'vigente' ? 'selected' : '' }}>Vigentes</option>
                            <option value="proximo" {{ request('filterbystatus') === 'proximo' ? 'selected' : '' }}>Próximos</option>
                            <option value="vencido" {{ request('filterbystatus') === 'vencido' ? 'selected' : '' }}>Vencidos</option>
                            <option value="suspendido" {{ request('filterbystatus') === 'suspendido' ? 'selected' : '' }}>Suspendidos</option>
                        </select>
                        <button type="submit" class="btn btn-secondary text-light" title="Buscar"><i class="bi bi-search"></i></button>
                        @if (request()->hasAny(['filterbyprogram', 'filterbycustomer', 'filterbydate', 'filterbystatus']))
                            <a href="{{ route('period.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th>ESTADO</th>
                            <th scope="col">PROGRAMA</th>
                            <th scope="col">CLIENTE / DOCUMENTO</th>
                            <th scope="col">VIGENCIA</th>
                            <th scope="col" style="min-width: 180px">AVANCE</th>
                            <th scope="col" class="text-end">TOTAL</th>
                            <th scope="col" style="min-width: 130px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($periods as $row)
                        @php
                            $today = Carbon\Carbon::today();
                            $start = Carbon\Carbon::parse($row->start_date);
                            $end = Carbon\Carbon::parse($row->end_date);
                            if ($row->status === 'Suspendido') {
                                $visualStatus = 'Suspendido'; $statusClass = 'bg-warning text-dark';
                            } elseif ($start->gt($today)) {
                                $visualStatus = 'Próximo'; $statusClass = 'bg-info text-dark';
                            } elseif ($end->lt($today)) {
                                $visualStatus = 'Vencido'; $statusClass = 'bg-secondary';
                            } else {
                                $visualStatus = 'Vigente'; $statusClass = 'bg-success';
                            }
                            $elapsed = min((int) $row->elapsed_deliveries, (int) $row->number_of_days);
                            $progress = $row->number_of_days > 0 ? min(100, round(($elapsed / $row->number_of_days) * 100)) : 0;
                        @endphp
                        <tr>
                            <td><span class="badge rounded-pill {{ $statusClass }}">{{ $visualStatus }}</span></td>
                            <td><span class="d-inline-block rounded-circle me-2" style="width: 14px; height: 14px; background: {{ $row->programcolor }}"></span>{{ $row->programname }}<div class="small text-muted">{{ $row->textcategoryprice }}</div></td>
                            <td>{{ $row->customername }}<div class="small text-muted">{{ $row->customerdocument ?: 'Sin documento' }}</div></td>
                            <td>{{ $start->format('d-m-Y') }} — {{ $end->format('d-m-Y') }}<div class="small text-muted">@if ($visualStatus === 'Vigente'){{ $row->remaining_deliveries }} días pendientes @elseif ($visualStatus === 'Próximo')Inicia en {{ $today->diffInDays($start) }} días @elseif ($visualStatus === 'Vencido')Finalizado hace {{ $end->diffInDays($today) }} días @endif</div></td>
                            <td>
                                <div class="d-flex justify-content-between small"><span>{{ $elapsed }} de {{ $row->number_of_days }}</span><span>{{ $progress }}%</span></div>
                                <div class="progress" style="height: 6px"><div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div></div>
                                <div class="small text-muted">Avance por calendario</div>
                            </td>
                            <td class="text-end fw-bold">S/ {{ number_format($row->total_price, 2) }}</td>
                            <td>
                                <div class="btnsaction">
                                    <form action="{{ route('period.destroy',$row->id)}}" method="POST" onsubmit="return confirm('¿Desea ocultar este período? Su información se conservará.')">
                                        <a href="{{ route('period.edit', $row->id) }}" class="btn btn-sm btn-outline-primary" title="Ver o editar"><i class="bi bi-pencil-square"></i></a>
                                        @if ($end->lt($today))
                                            <a href="{{ route('period.create', ['customer_id' => $row->id_customer, 'programprice_id' => $row->id_programprice]) }}" class="btn btn-sm btn-success" title="Renovar"><i class="bi bi-arrow-repeat"></i></a>
                                        @endif
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Ocultar"><i class="bi bi-eye-slash-fill"></i></button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">No se encontraron períodos con los filtros indicados.</td></tr>
                        @endforelse

                    </tbody>

                </table>

                <div class="d-flex justify-content-center">
                    {!! $periods->links() !!}
                </div>

            </div>
        </div>
    </div>

</div>

@endsection


@section('customscripts')

<script>
    $(document).ready(function(){

        $("#inputsearchdatestart").datepicker({
		    format: 'dd-mm-yyyy',
            autoclose: true,
            language: 'es',
            todayHighlight: true
	    })
    

    })
</script>

@endsection

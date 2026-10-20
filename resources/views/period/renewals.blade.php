@extends('layouts.maintemplate')

@section('title', 'Renovación de periodos')

@section('content')
<div class="row mt-4 mb-4">
    @if(session('success'))<div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex flex-wrap align-items-center gap-3">
                <h5 class="me-auto mb-0">Periodos disponibles para renovación</h5>
                <form action="{{ route('period.renewals') }}" method="GET" class="d-flex flex-wrap gap-2">
                    <input type="search" name="filterbyprogram" class="form-control w-auto" value="{{ request('filterbyprogram') }}" placeholder="Buscar programa...">
                    <input type="search" name="filterbycustomer" class="form-control w-auto" value="{{ request('filterbycustomer') }}" placeholder="Cliente o documento...">
                    <input type="text" name="filterbydate" id="renewal-date" class="form-control w-auto" value="{{ request('filterbydate') }}" placeholder="Fecha final..." autocomplete="off">
                    <button type="submit" class="btn btn-secondary" title="Buscar"><i class="bi bi-search"></i></button>
                    @if (request()->filled('filterbyprogram') || request()->filled('filterbycustomer') || request()->filled('filterbydate'))
                        <a href="{{ route('period.renewals') }}" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>PROGRAMA</th>
                            <th>CLIENTE</th>
                            <th>DOCUMENTO</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FINAL</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($currentProgramGroup = null)
                        @forelse ($periods as $period)
                            @php($programGroup = $period->programname . '|' . $period->textcategoryprice)
                            @if($currentProgramGroup !== $programGroup)
                                <tr>
                                    <td colspan="7" class="fw-bold text-white py-2" style="background: {{ $period->programcolor }}">
                                        <i class="bi bi-collection me-2"></i>{{ $period->programname }} / {{ $period->textcategoryprice }}
                                    </td>
                                </tr>
                                @php($currentProgramGroup = $programGroup)
                            @endif
                            <tr style="border-left:6px solid {{ $period->programcolor }}">
                                <td><i class="bi bi-calendar-check px-3 py-1 rounded-pill" style="background: {{ $period->programcolor }}"></i></td>
                                <td>{{ $period->programname }} / {{ $period->textcategoryprice }}</td>
                                <td>{{ $period->customername }}</td>
                                <td>{{ $period->customerdocument ?: 'Sin documento' }}</td>
                                <td>{{ Carbon\Carbon::parse($period->start_date)->format('d-m-Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($period->end_date)->format('d-m-Y') }}</td>
                                <td class="text-end">
                                    @if (Carbon\Carbon::parse($period->end_date)->lt(Carbon\Carbon::today()))
                                        <a href="{{ route('period.create', ['customer_id' => $period->id_customer, 'programprice_id' => $period->id_programprice]) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-arrow-repeat"></i> Generar nuevo período
                                        </a>
                                    @endif
                                    <a href="{{ route('customer.edit',$period->id_customer) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-lines-fill"></i> Ver cliente</a>
                                    <form action="{{ route('period.cancel',$period->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Anular este período?')">@csrf @method('PATCH')<button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Anular</button></form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">No hay periodos pendientes de renovación.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center pt-3">
                {{ $periods->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('customscripts')
<script>$(function(){$('#renewal-date').datepicker({format:'dd-mm-yyyy',autoclose:true,language:'es'})})</script>
@endsection

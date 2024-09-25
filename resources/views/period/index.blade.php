@extends('layouts.maintemplate')

@section('title', 'Periodos')

@section('buttonsarea')
<a href="{{  url('deliveriesoftheday') }}" class="btn btn-secondary mx-2" role="button"><i class="bi bi-list"></i> Entregas del día</a>
    <a href="{{  url('period/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">
                <h5 class="me-auto">Lista de periodos</h5>
                <div class="">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="filterbyprogram" class="form-control mx-2" value="{{ Request::get('filterbyprogram') }}" placeholder="Buscar por programa...">
                        <input type="text" name="filterbycustomer" class="form-control mx-2" value="{{ Request::get('filterbycustomer') }}" placeholder="Buscar por cliente...">
                        <input type="text" name="filterbydate" id="inputsearchdatestart" value="{{ Request::get('filterbydate') }}" autocomplete="off" class="form-control mx-2" placeholder="Buscar por fecha de inicio...">
                        <button type="submit" class="btn btn-secondary text-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th style="width: 60px"></th>
                            <th scope="col">PROGRAMA</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col" class="text-center">UNIDAD</th>
                            <th scope="col">F. INICIO</th>
                            <th scope="col">F. FINAL</th>
                            <th scope="col" width="65px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($periods as $row)
                        <tr>
                            <td><i class="bi bi-calendar-check px-3 py-1 rounded-pill" style="background: {{$row->programcolor}}"></i></td>
                            <td>{{ $row->programname }} / {{ $row->textcategoryprice }}</td>
                            <td>{{ $row->customername }}</td>
                            <td class="text-center">{{ $row->number_of_days }}</td>
                            <td>{{ Carbon\Carbon::parse($row->start_date)->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($row->end_date)->format('d-m-Y') }}</td>
                            <td>
                                <div class="btnsaction">
                                    <form action="{{ route('period.destroy',$row->id)}}" method="POST">
                                        <a href="/period/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 ms-2 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach

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
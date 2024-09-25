@extends('layouts.maintemplate')

@section('title', 'Feriados')

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-3">
        <div class="card p-3 mb-3">
            <form action="/holiday" method="POST">
                @csrf
                <h5>Añadir Feriado</h5>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <div class="input-group dvdate">
                        <input type="text" name="date" id="inputdate" class="form-control" autocomplete="off" aria-describedby="inputspdate" required>
                        <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nota</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>
                
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card p-3">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th scope="col"><i class="bi bi-calendar-x"></i></th>
                        <th scope="col">FECHA</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">NOTA</th>
                        <th scope="col" width="65px">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($holidays as $row)
                    <tr>
                        <th scope="row"><i class="bi bi-calendar-x"></i></th>
                        <td>{{ Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->note }}</td>
                        <td>
                            <div class="btnsaction">
                                <form action="{{ route('holiday.destroy',$row->id)}}" method="POST">
                                    <a href="/holiday/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
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
        </div>
    </div>

</div>

@endsection


@section('customscripts')

<script>
    $(document).ready(function(){

        $("#inputdate").datepicker({
		    format: 'dd-mm-yyyy',
            autoclose: true,
            language: 'es',
            todayHighlight: true
	    })

    })
</script>

@endsection
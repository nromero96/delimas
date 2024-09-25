@extends('layouts.maintemplate')

@section('title', 'Distritos')

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-3">
        <div class="card p-3 mb-3">
            <form action="/districts" method="POST">
                @csrf
                <h5>Añadir Distrito</h5>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card p-3">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 30px;"><i class="bi bi-check-lg"></i></i></th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col" width="65px">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($districts as $row)
                    <tr>
                        <th scope="row"><i class="bi bi-check-lg"></i></i></th>
                        <td>{{ $row->name }}</td>
                        <td>
                            <div class="btnsaction">
                                <form action="{{ route('districts.destroy',$row->id)}}" method="POST">
                                    <a href="/districts/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
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
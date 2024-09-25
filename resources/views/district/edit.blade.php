@extends('layouts.maintemplate')

@section('title','Editar Distrito')

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card p-3 mb-3">
            <form action="/districts/{{$district->id}}" method="POST">
                @csrf
                @method('PUT')
                <h5>Editar Distrito</h5>


                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{$district->name}}" required>
                </div>
                <a class="btn btn-secondary" href="{{  url('districts') }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
    <div class="col-md-4"></div>


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
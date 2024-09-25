@extends('layouts.maintemplate')

@section('title','Editar Fecha')

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card p-3 mb-3">
            <form action="/holiday/{{$holiday->id}}" method="POST">
                @csrf
                @method('PUT')
                <h5>Editar Fecha</h5>

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <div class="input-group dvdate">
                        <input type="text" name="date" id="inputdate" class="form-control" value="{{ Carbon\Carbon::parse($holiday->date)->format('d-m-Y') }}" autocomplete="off" aria-describedby="inputspdate" required>
                        <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{$holiday->name}}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nota</label>
                    <textarea name="note" class="form-control" rows="3">{{$holiday->note}}</textarea>
                </div>
                
                <a class="btn btn-secondary" href="{{  url('holiday') }}" role="button">Cancelar</a>
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
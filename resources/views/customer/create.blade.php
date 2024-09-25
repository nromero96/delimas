@extends('layouts.maintemplate')

@section('title', 'Añadir un nuevo cliente')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        <form action="/customer" class="row" method="POST">
            @csrf

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo Documento</label>
                <select class="form-select" name="documenttype" required>
                    <option selected disabled value="">Seleccione...</option>
                    <option value="DNI">DNI</option>
                    <option value="CARNET EXT.">CARNET EXT.</option>
                    <option value="OTROS">OTROS</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° Documento</label>
                <input type="number" name="documentnumber" class="form-control" required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Nombre y Apellidos</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Distrito</label>
                <select class="form-select" name="district" required>
                    <option selected disabled value="">Seleccione...</option>

                    @foreach ($districts as $item)
                        <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Restricción</label>
                <input type="text" name="restriction" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Recomendación</label>
                <input type="text" name="recommendation" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="hidden" name="status" value="Inactivo">
                    <input class="form-check-input" type="checkbox" name="status" id="statuscustomer" value="Activo" checked>
                    <label class="form-check-label" for="statuscustomer"> Estado</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <a class="btn btn-secondary" href="{{  url('customer') }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>

        </form>
    </div>

@endsection
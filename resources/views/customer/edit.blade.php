@extends('layouts.maintemplate')

@section('title', 'Editar Cliente')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        <form action="/customer/{{$customer->id}}" class="row" method="POST">
            @csrf
            @method('PUT')

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo Documento</label>
                <select class="form-select" name="documenttype" required>
                    <option disabled value="">Seleccione...</option>
                    <option value="DNI" {{ ( $customer->document_type == 'DNI') ? 'selected' : '' }}>DNI</option>
                    <option value="CARNET EXT." {{ ( $customer->document_type == 'CARNET EXT.') ? 'selected' : '' }}>CARNET EXT.</option>
                    <option value="OTROS" {{ ( $customer->document_type == 'OTROS') ? 'selected' : '' }}>OTROS</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° Documento</label>
                <input type="number" name="documentnumber" class="form-control" value="{{$customer->document_number}}" required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Nombre y Apellidos</label>
                <input type="text" name="name" class="form-control" value="{{$customer->name}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{$customer->address}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Distrito</label>
                <select class="form-select" name="district" required>
                    <option disabled value="">Seleccione...</option>

                    @foreach ($districts as $item)

                        <option value="{{$item->name}}" {{ ( $customer->district == $item->name) ? 'selected' : '' }}>{{$item->name}}</option>

                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{$customer->phone}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{$customer->email}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Restricción</label>
                <input type="text" name="restriction" class="form-control" value="{{$customer->restriction}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Recomendación</label>
                <input type="text" name="recommendation" class="form-control" value="{{$customer->recommendation}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="hidden" name="status" value="Inactivo">
                    <input class="form-check-input" type="checkbox" name="status" id="statuscustomer" value="Activo" {{$customer->status == 'Activo' ? 'checked' : ''}}>
                    <label class="form-check-label" for="statuscustomer"> Estado</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <a class="btn btn-secondary" href="{{  url('customer') }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
                
        </form>  
    </div>

@endsection
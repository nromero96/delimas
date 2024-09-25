@extends('layouts.maintemplate')

@section('title', 'Editar usuario')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        <div class="row">
            <div class="col-md-6">

                <form action="/users" class="row" method="POST">
                    @csrf
        
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nombre y Apellido</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                    </div>
        
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                    </div>
        
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rol del usuario</label>
                        <select class="form-select" name="role" required>
                            <option disabled value="">Seleccione...</option>
                            <option value="Administrador" {{ ( $user->role == 'Administrador') ? 'selected' : '' }}>Administrador</option>
                            {{-- <option value="Vendedor"  {{ ( $user->role == 'Vendedor') ? 'selected' : '' }}>Vendedor</option>
                            <option value="Cliente"  {{ ( $user->role == 'Cliente') ? 'selected' : '' }}>Cliente</option> --}}
                        </select>
                    </div>
        
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="********">
                    </div>
        
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="Inactivo">
                            <input class="form-check-input" type="checkbox" name="status" id="statususer" value="Activo" {{$user->status == 'Activo' ? 'checked' : ''}}>
                            <label class="form-check-label" for="statususer"> Estado</label>
                        </div>
                    </div>
        
                    <div class="col-md-12 mb-3">
                        <a class="btn btn-secondary" href="{{  url('users') }}" role="button">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>

            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('/images/icono-registro-1.png')}}" alt="...">
            </div>
        </div>
    </div>

@endsection
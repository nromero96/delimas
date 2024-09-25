@extends('layouts.maintemplate')

@section('title', 'Usuarios')

@section('buttonsarea')
<a href="{{  url('users/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">
                <h5 class="me-auto">Lista de usuarios</h5>
                <div class="">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="filterbyname" class="form-control mx-2" value="{{ Request::get('filterbyname') }}" placeholder="Buscar por nombre...">
                        <input type="text" name="filterbyemail" class="form-control mx-2" value="{{ Request::get('filterbyemail') }}" placeholder="Buscar por correo...">
                        <button type="submit" class="btn btn-secondary text-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">NOMBRE Y APELLIDO</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col" width="65px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td><span class="badge rounded-pill {{$row->status == 'Activo' ? 'bg-success' : 'bg-danger'}}">{{$row->status}}</span></td>
                            <td>
                                <div class="btnsaction">
                                    <form action="{{ route('users.destroy',$row->id)}}" method="POST">
                                        <a href="/users/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
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
                {{-- <div class="d-flex justify-content-center">
                    {!! $customers->links() !!}
                </div> --}}
            </div>
        </div>
    </div>

</div>

@endsection
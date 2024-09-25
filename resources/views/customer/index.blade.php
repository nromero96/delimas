@extends('layouts.maintemplate')

@section('title', 'Clientes')

@section('buttonsarea')
<a href="{{  url('customer/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">
                <h5 class="me-auto">Lista de clientes</h5>
                <div class="">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="filterbynumdoc" class="form-control mx-2" value="{{ Request::get('filterbynumdoc') }}" placeholder="Buscar por n° documento...">
                        <input type="text" name="filterbyname" class="form-control mx-2" value="{{ Request::get('filterbyname') }}" placeholder="Buscar por nombre...">
                        <input type="text" name="filterbydistrict" class="form-control mx-2" value="{{ Request::get('filterbydistrict') }}" placeholder="Buscar por distrito...">
                        <button type="submit" class="btn btn-secondary text-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">TIPO DOC.</th>
                            <th scope="col">N° DOC.</th>
                            <th scope="col">NOMBRE Y APELLIDO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">DISTRITO</th>
                            <th scope="col">TELÉFONO</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">FECHA REGISTRO</th>
                            <th scope="col" width="65px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($customers as $row)
                        <tr>
                            <td>{{ $row->document_type }}</td>
                            <td>{{ $row->document_number }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->address }}</td>
                            <td>{{ $row->district }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->email }}</td>
                            <td><span class="badge rounded-pill {{$row->status == 'Activo' ? 'bg-success' : 'bg-danger'}}">{{ $row->status }}</span></td>
                            <td>{{ $row->created_at }}</td>
                            <td>
                                <div class="btnsaction">
                                    <form action="{{ route('customer.destroy',$row->id)}}" method="POST">
                                        <a href="/customer/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
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
                    {!! $customers->links() !!}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
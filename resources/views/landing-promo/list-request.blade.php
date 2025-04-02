@extends('layouts.maintemplate')

@section('title', 'Pedidos de Menú')

@section('buttonsarea')
<a href="{{  url('/') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">


    <div class="col-md-12">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">
                <h5 class="me-auto">Lista de pedidos</h5>
                <div class="">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="filterbyid" class="form-control mx-2" value="{{ Request::get('filterbyid') }}" placeholder="Buscar por ID">
                        <input type="text" name="filterbyname" class="form-control mx-2" value="{{ Request::get('filterbyname') }}" placeholder="Buscar por nombre...">
                        <input type="text" name="filterbyphone" class="form-control mx-2" value="{{ Request::get('filterbyphone') }}" placeholder="Buscar por teléfono...">
                        <button type="submit" class="btn btn-secondary text-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRE Y APELLIDO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">PRODUCTO Y PLAN</th>
                            <th scope="col">TELÉFONO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">FECHA REGISTRO</th>
                            <th scope="col" width="65px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($planrequests as $row)
                        <tr class="border-bottom">
                            <td class="align-middle"><a href="/show-request/{{ $row->id }}">#{{ $row->id }}</a></td>
                            <td class="align-middle">{{ $row->name }}</td>
                            <td class="align-middle">{{ $row->address }}</td>
                            <td class="align-middle">{{ $row->product }}<br><small class="text-muted">{{ $row->plan }}</small></td>
                            <td class="align-middle">{{ $row->phone }}</td>
                            <td class="align-middle">
                                <span class="badge rounded-pill 
                                    @if($row->status == 'Atendido') bg-success 
                                    @elseif($row->status == 'Pendiente') bg-warning 
                                    @elseif($row->status == 'Rechazado') bg-danger 
                                    @endif">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <span class="badge rounded-pill bg-light text-dark">
                                    {{ $row->created_at->format('Y-m-d') }}<br>
                                    <small>{{ $row->created_at->format('H:i:s') }}</small>
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="btnsaction">
                                    <a href="/show-request/{{ $row->id }}" class="btn p-0 btn-md text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $planrequests->links() !!}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
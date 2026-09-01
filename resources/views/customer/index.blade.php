@extends('layouts.maintemplate')

@section('title', 'Clientes')

@section('buttonsarea')
<a href="{{  url('customer/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
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
                <h5 class="me-auto">Lista de clientes</h5>
                <div>
                    <form action="{{ route('customer.index') }}" method="GET" class="d-flex flex-wrap gap-2 justify-content-end">
                        <input type="search" name="filterbynumdoc" class="form-control w-auto" value="{{ request('filterbynumdoc') }}" maxlength="20" placeholder="Buscar por n° documento...">
                        <input type="search" name="filterbyname" class="form-control w-auto" value="{{ request('filterbyname') }}" maxlength="255" placeholder="Buscar por nombre...">
                        <input type="search" name="filterbydistrict" class="form-control w-auto" value="{{ request('filterbydistrict') }}" maxlength="50" placeholder="Buscar por distrito...">
                        <button type="submit" class="btn btn-secondary text-light" title="Buscar"><i class="bi bi-search"></i></button>
                        @if (request()->filled('filterbynumdoc') || request()->filled('filterbyname') || request()->filled('filterbydistrict'))
                            <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros"><i class="bi bi-x-lg"></i></a>
                        @endif
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

                        @forelse ($customers as $row)
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
                                    <form action="{{ route('customer.destroy',$row->id)}}" method="POST" onsubmit="return confirmDelete()">
                                        <a href="/customer/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 ms-2 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Ocultar cliente"><i class="bi bi-eye-slash-fill"></i></button>
                                    </form>
                                    
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">No se encontraron clientes con los filtros indicados.</td>
                            </tr>
                        @endforelse

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


@section('customscripts')
<script>

    //If click Delete Customer confirmation 
    confirmDelete = () => {
        return confirm('¿Desea ocultar este cliente? Su información se conservará.');
    }


</script>

@endsection

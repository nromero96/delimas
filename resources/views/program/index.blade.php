@extends('layouts.maintemplate')

@section('title', 'Programas')

@section('buttonsarea')
    <a href="{{  url('program/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-12">
        <div class="card shadow p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">NOMBRE</th>
                            <th style="width: 70px;">ESTADO</th>
                            <th style="width: 150px;">REGISTRADO</th>
                            <th style="width: 60px;">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $row)
                        <tr">
                            <td style="width: 45px;"><i class="bi bi-clipboard-check px-2 py-1 rounded-circle" style="background:#cee691"></i></td>
                            <td>{{ $row->name }}</td>
                            <td><span class="badge rounded-pill {{$row->status == 'Activo' ? 'bg-success' : 'bg-danger'}}">{{ $row->status }}</span></td>
                            <td>{{ $row->created_at }}</td>
                            <td>
                                <div class="btnsaction" style="width: 45px;">
                                    <form action="{{ route('program.destroy',$row->id)}}" method="POST">
                                        <a href="/program/{{ $row->id }}/edit" class="btn p-0 text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a> 
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

</div>

@endsection
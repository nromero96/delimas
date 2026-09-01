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
                        @forelse ($programs as $row)
                        <tr>
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
                        <tr>
                            <td></td>
                            <td colspan="4" class="pt-0 pb-4">
                                <div class="border rounded overflow-hidden">
                                    <div class="bg-light px-3 py-2 d-flex align-items-center">
                                        <strong class="me-auto">Lista de precios</strong>
                                        <span class="badge bg-secondary">{{ $row->prices->count() }} {{ $row->prices->count() === 1 ? 'categoría' : 'categorías' }}</span>
                                    </div>
                                    @if ($row->prices->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless align-middle mb-0">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th>CATEGORÍA</th>
                                                        <th class="text-end">1 MENÚ</th>
                                                        <th class="text-end">5 MENÚS</th>
                                                        <th class="text-end">10 MENÚS</th>
                                                        <th class="text-end">20 MENÚS</th>
                                                        <th class="text-end">30 MENÚS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($row->prices as $price)
                                                        <tr>
                                                            <td>
                                                                <span class="d-inline-block rounded-circle me-2" style="width: 14px; height: 14px; background: {{ $price->color }};"></span>
                                                                {{ $price->textcategoryprice }}
                                                            </td>
                                                            <td class="text-end">S/ {{ number_format($price->oneprice, 2) }}</td>
                                                            <td class="text-end">S/ {{ number_format($price->fiveprice, 2) }}</td>
                                                            <td class="text-end">S/ {{ number_format($price->tenprice, 2) }}</td>
                                                            <td class="text-end">S/ {{ number_format($price->twentyprice, 2) }}</td>
                                                            <td class="text-end">S/ {{ number_format($price->thirtyprice, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-muted px-3 py-3">Este programa todavía no tiene precios configurados.</div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4">No hay programas registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@extends('layouts.maintemplate')

@section('title', 'Información de la solicitud')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        <div class="row">
            <div class="col-md-6">

                <form action="{{ route('updaterequeststatus', $planrequest->id) }}" class="row" method="POST">
                    @csrf
        
                    <div class="col-md-8 mb-2">
                        <label class="form-label">Nombre y Apellido</label>
                        <p class="form-control  mb-0">{{$planrequest->name}}</p>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Solicituda</label>
                        <p class="form-control mb-0">{{$planrequest->created_at->format('d/m/Y - H:i')}}</p>
                    </div>
        
                    <div class="col-md-8 mb-2">
                        <label class="form-label">Dirección</label>
                        <p class="form-control mb-0">{{$planrequest->address}}</p>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Distrito</label>
                        <p class="form-control mb-0">{{$planrequest->district}}</p>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label">Producto</label>
                        <p class="form-control mb-0">{{$planrequest->product}}</p>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label">Plan</label>
                        <p class="form-control mb-0">{{$planrequest->plan}}</p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label">Teléfono</label>
                        <p class="form-control mb-0">{{$planrequest->phone}}</p>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label">DNI</label>
                        <p class="form-control mb-0">{{$planrequest->document}}</p>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label">Pago</label>
                        <p class="form-control mb-0">{{$planrequest->payment}}</p>

                        @if($planrequest->voucher != null)
                            <a href="{{ asset('storage/vouchers/'.$planrequest->voucher) }}" target="_blank">Ver comprobante</a>
                        @endif

                    </div>

        
        
                    <div class="col-md-12 mb-3">
                        <div class="card border p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Estado de la solicitud</label>
                                    <select class="form-select" name="status" required>
                                        <option disabled value="">Seleccione...</option>
                                        <option value="Pendiente" {{ ( $planrequest->status == 'Pendiente') ? 'selected' : '' }}>Pendiente</option>
                                        <option value="Atendido"  {{ ( $planrequest->status == 'Atendido') ? 'selected' : '' }}>Atendido</option>
                                        <option value="Rechazado"  {{ ( $planrequest->status == 'Rechazado') ? 'selected' : '' }}>Rechazado</option>
                                    </select>
                                </div>
                                <div class="col-md-6 pt-1">
                                    <input type="submit" class="btn btn-primary w-100 mt-4" value="Actualizar">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('/images/icono-registro-1.png')}}" alt="...">
            </div>
        </div>
    </div>

@endsection
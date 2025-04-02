@extends('layouts.maintemplate')

@section('title', 'Dashboard')

@section('content')

<div class="row mt-3">
    <div class="col-md-12 pt-5 welcmbox">
        <h1 class="text-center">¡Bienvenido!</h1>
        <div class="text-center">
            <img src="{{ asset('/images/logo.png')}}" alt="LOGO">
        </div>
        
        <p class="text-center">Disfruta vivir saludable, comiendo delicioso y de la manera más práctica.</p>
    </div>

    <div class="col-md-12 pb-5 pt-2">

        <div class="row">
            <div class="col-md-4 optionshome mb-4">
                <a href="/customer" class="shadow pt-0 pb-3">
                    <i class="bi bi-people"></i>
                    <span>Registro de Clientes</span>
                </a>
            </div>
            <div class="col-md-4 optionshome mb-4">
                <a href="/period" class="shadow pt-0 pb-3">
                    <i class="bi bi-calendar-range"></i>
                    <span>Registro de Periodos</span>
                </a>
            </div>
            <div class="col-md-4 optionshome mb-4">
                <a href="{{ route('listrequest') }}" class="shadow pt-0 pb-3">
                    <i class="bi bi-card-list"></i>
                    <span>Solicitudes de Menú</span>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delimas - Libro de reclamaciones</title>

    <style>
        @font-face {
            font-family: 'Omnes-Regular';
            src: url('/fonts/Omnes-Regular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Ballet Harmony';
            src: url('/fonts/Ballet-Harmony.ttf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aleo:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card mt-5 mb-5">
                    <div class="card-header text-center">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid mb-2" style="max-width: 150px;">
                        </a>
                        <h1 class="text-primary">Libro de Reclamaciones</h1>
                    </div>
                    <div class="card-body">

                        {{-- success --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- error --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="reclamacionForm" method="POST" action="{{ route('enviar-reclamo') }}">
                            {{-- CSRF Token --}}
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha de la Reclamación</label>
                                <input type="date" class="form-control" id="date" name="date" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción de la Reclamación</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="solution" class="form-label">Solicitud de Solución</label>
                                <textarea class="form-control" id="solution" name="solution" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Reclamación</button> <a href="{{ url('/') }}" class="ms-3">Volver a Inicio</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Obtener la fecha actual en formato YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];

        // Asignar la fecha al input
        document.getElementById("date").value = today;

        //Agregrar el evento submit al formulario efecto enviando con animacion de bootrap 5
        document.getElementById('reclamacionForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true; // Deshabilitar el botón para evitar múltiples envíos

            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...'; // Cambiar el texto del botón

            // Enviar el formulario
            this.submit();
        });    



    </script>

</body>
</html>

@extends('layouts.maintemplate')

@section('title','Ajustes del Landing Page')

@section('content')

<div class="row mt-4 mb-4">

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3 mb-3">
                <form action="{{ route('landingsetting.save.menu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>Menú Semanal: <input type="text" name="weekly_title" class="form-control" value="{{ $weekly_title }}" placeholder="Menú del 1 de febrero al 7 de febrero"></h5>
                    <div id="menus-container">
                        @foreach ($menus as $index => $menu)
                            <div class="card p-3 mb-3 option-menu" style="background: #f1f8e0;" data-index="{{ $index }}">
                                <button type="button" class="btn btn-danger btn-sm remove-menu" style="position: absolute; top: 10px; right: 10px;">X</button>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="form-label mb-0">Título:</label>
                                        <input type="text" name="menus[{{ $index }}][title]" class="form-control" value="{{ $menu['title'] ?? '' }}"  placeholder="Ejemplo: Opción 1">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0">Color:</label>
                                        <input type="color" name="menus[{{ $index }}][color]" class="form-control form-control-color" value="{{ $menu['color'] ?? '#f8764a' }}">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <h5>Days</h5>

                                    @foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $day)
                                        <div class="col-md-4 mb-4">
                                            <div class="card"
                                                @if (!empty($menu['days'][$day]['image']))
                                                    style="background-image: url('{{ asset($menu['days'][$day]['image']) }}'); background-size: 60px 60px;background-repeat: no-repeat;background-position-x: right;background-position-y: top;"
                                                @endif
                                                >
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ ucfirst($day) }}</h5>
                                                    <div class="mb-1">
                                                        <label class="form-label mb-0">Foto</label>
                                                        <input type="file" name="menus[{{ $index }}][days][{{ $day }}][image]" class="form-control" placeholder="Image URL">
                                                    </div>
                                                    <div class="mb-1">
                                                        <input type="text" name="menus[{{ $index }}][days][{{ $day }}][title]" class="form-control" value="{{ $menu['days'][$day]['title'] ?? '' }}" placeholder="Título del plato">
                                                    </div>
                                                    <div class="mb-1">
                                                        <textarea name="menus[{{ $index }}][days][{{ $day }}][description]" class="form-control" rows="3" placeholder="Descripción del plato">{{ $menu['days'][$day]['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" id="add-menu">Agregar</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Menu</button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3 mb-3">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <h5>Producto y Planes</h5>
    
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <div class="input-group dvdate">
                            <input type="text" name="date" id="inputdate" class="form-control" value="" autocomplete="off" aria-describedby="inputspdate" required>
                            <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nota</label>
                        <textarea name="note" class="form-control" rows="3">---</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>


</div>

@endsection


@section('customscripts')

<script>
    document.getElementById('add-menu').addEventListener('click', function () {
        let menusContainer = document.getElementById('menus-container');
        let menuIndex = document.querySelectorAll('.option-menu').length; // Obtener índice dinámico

        let newMenu = document.createElement('div');
        newMenu.classList.add('card', 'p-3', 'mb-3', 'option-menu');
        newMenu.style.background = "#f1f8e0";
        newMenu.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm remove-menu" style="position: absolute; top: 10px; right: 10px;">X</button>
            <div class="row">
                <div class="col-md-8">
                    <label class="form-label mb-0">Título:</label>
                    <input type="text" name="menus[${menuIndex}][title]" class="form-control" placeholder="Ejemplo: Opción ${menuIndex + 1}">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0">Color:</label>
                    <input type="color" name="menus[${menuIndex}][color]" class="form-control form-control-color" value="#f8764a">
                </div>
            </div>
            <div class="row mt-2">
                <h5>Days</h5>
                ${['lunes', 'martes', 'miercoles', 'jueves', 'viernes'].map(day => `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${day.charAt(0).toUpperCase() + day.slice(1)}</h5>
                                <div class="mb-1">
                                    <label class="form-label mb-0">Foto</label>
                                    <input type="file" name="menus[${menuIndex}][days][${day}][image]" class="form-control">
                                </div>
                                <div class="mb-1">
                                    <input type="text" name="menus[${menuIndex}][days][${day}][title]" class="form-control" placeholder="Título del plato">
                                </div>
                                <div class="mb-1">
                                    <textarea name="menus[${menuIndex}][days][${day}][description]" class="form-control" rows="3" placeholder="Descripción del plato"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
        menusContainer.appendChild(newMenu);
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-menu')) {
            let menuCard = event.target.closest('.option-menu');
            menuCard.remove();
        }
    });

</script>

@endsection
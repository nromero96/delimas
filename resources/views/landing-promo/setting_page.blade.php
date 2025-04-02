@extends('layouts.maintemplate')

@section('title','Ajustes del Landing Page')

@section('content')

<div class="row mt-4 mb-4">


    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card p-3 mb-3">
                <form action="{{ route('landingsetting.save.menu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>Menú Semanal: <input type="text" name="weekly_title" class="form-control" value="{{ $weekly_title }}" placeholder="Menú del 1 de febrero al 7 de febrero"></h5>
                    <div id="menus-container">
                        @foreach ($menus as $index => $menu)
                            <div class="card p-3 mb-3 option-menu" style="background: #f1f8e0;" data-index="{{ $index }}">
                                <button type="button" class="btn btn-danger rounded-circle btn-sm remove-menu"><i class="bi bi-x"></i></button>
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
                                    <h5>Dias</h5>

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
                        <button type="button" class="btn btn-secondary rounded-circle" id="add-menu"><i class="bi bi-plus-circle"></i></button>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Menu</button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card healthplans p-3 mb-3">
                <form action="{{ route('landingsetting.save.healthplans') }}" method="POST">
                    @csrf
                
                    @foreach (['almuerzos_saludables' => 'Almuerzos Saludables', 'dieta_saludable' => 'Dieta Saludable'] as $planKey => $planTitle)
                        <h2>{{ $planTitle }}</h2>
                        
                        @php
                            $planData = $planKey === 'almuerzos_saludables' ? $almuerzosData : $dietaData;
                        @endphp

                        
                
                        @foreach (['estandar', 'personalizado'] as $tipo)
                            <div class="standard-personalized">
                                <h3>{{ ucfirst($tipo) }}</h3>
                                @if($planKey === 'almuerzos_saludables')
                                    Los de almuerzo saludable
                                    @foreach (['pequeno', 'mediano', 'mantenimiento'] as $categoria)
                                        <div class="reduce-mantain">
                                            <h4>{{ ucfirst($categoria) }}</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Días</th>
                                                        <th>Precio</th>
                                                        <th>Nota</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-{{ $planKey }}-{{ strtolower($tipo) }}-{{ strtolower($categoria) }}">
                                                    @php
                                                        $items = $planData[$tipo][$categoria] ?? [];
                                                    @endphp
                            
                                                    @foreach ($items as $index => $item)
                                                        <tr>
                                                            <td><input type="text" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][dias]" class="form-control" value="{{ $item['dias'] }}" required></td>
                                                            <td><input type="number" step="0.01" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][precio]" class="form-control" value="{{ $item['precio'] }}" required></td>
                                                            <td><input type="text" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][nota]" class="form-control" value="{{ $item['nota'] }}" required></td>
                                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-secondary" onclick="addRowAlmuerzo('{{ $planKey }}', '{{ strtolower($tipo) }}', '{{ strtolower($categoria) }}')">
                                                Agregar fila
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    Los de dieta saludable
                                    @foreach (['reduccion', 'mantenimiento'] as $categoria)
                                        <div class="reduce-mantain">
                                            <h4>{{ ucfirst($categoria) }}</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Días</th>
                                                        <th>Precio con desayuno, almuerzo y cena</th>
                                                        <th>Precio sin desayuno ni snack</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-{{ $planKey }}-{{ strtolower($tipo) }}-{{ strtolower($categoria) }}">
                                                    @php
                                                        $items = $planData[$tipo][$categoria] ?? [];
                                                    @endphp
                            
                                                    @foreach ($items as $index => $item)
                                                        <tr>
                                                            <td><input type="text" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][dias]" class="form-control" value="{{ $item['dias'] }}" required></td>
                                                            <td><input type="number" step="0.01" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][precio_des_alm_cena]" class="form-control" value="{{ $item['precio_des_alm_cena'] }}" required></td>
                                                            <td><input type="number" step="0.01" name="{{ $planKey }}[{{ $tipo }}][{{ $categoria }}][{{ $index }}][precio_sin_des_ni_snak]" class="form-control" value="{{ $item['precio_sin_des_ni_snak'] }}" required></td>
                                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-secondary" onclick="addRow('{{ $planKey }}', '{{ strtolower($tipo) }}', '{{ strtolower($categoria) }}')">
                                                Agregar fila
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                                
                            </div>
                        @endforeach
                    @endforeach
                    <br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
            <button type="button" class="btn btn-danger btn-sm remove-menu"><i class="bi bi-x"></i></button>
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
                <h5>Dias</h5>
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

    function addRowAlmuerzo(planKey, tipo, categoria) {
        let tbody = document.getElementById(`tbody-${planKey}-${tipo}-${categoria}`);
        let index = tbody.children.length;

        let row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="${planKey}[${tipo}][${categoria}][${index}][dias]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="${planKey}[${tipo}][${categoria}][${index}][precio]" class="form-control" required></td>
            <td><input type="text" name="${planKey}[${tipo}][${categoria}][${index}][nota]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
        `;

        tbody.appendChild(row);
    }


    function addRow(planKey, tipo, categoria) {
        let tbody = document.getElementById(`tbody-${planKey}-${tipo}-${categoria}`);
        let index = tbody.children.length;

        let row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="${planKey}[${tipo}][${categoria}][${index}][dias]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="${planKey}[${tipo}][${categoria}][${index}][precio_des_alm_cena]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="${planKey}[${tipo}][${categoria}][${index}][precio_sin_des_ni_snak]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button></td>
        `;

        tbody.appendChild(row);
    }

    function removeRow(button) {
        button.closest('tr').remove();
    }



</script>

@endsection
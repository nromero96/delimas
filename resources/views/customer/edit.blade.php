@extends('layouts.maintemplate')

@section('title', 'Editar Cliente')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        <form action="/customer/{{$customer->id}}" class="row" method="POST">
            @csrf
            @method('PUT')

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo Documento</label>
                <select class="form-select" name="documenttype" id="documenttype">
                    <option disabled value="">Seleccione...</option>
                    <option value="DNI" {{ ( $customer->document_type == 'DNI') ? 'selected' : '' }}>DNI</option>
                    <option value="CARNET EXT." {{ ( $customer->document_type == 'CARNET EXT.') ? 'selected' : '' }}>CARNET EXT.</option>
                    <option value="OTROS" {{ ( $customer->document_type == 'OTROS') ? 'selected' : '' }}>OTROS</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° Documento</label>
                <input type="text" name="documentnumber" id="documentnumber" inputmode="numeric" pattern="\d{8}" maxlength="8" class="form-control" value="{{$customer->document_number}}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{$customer->name}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Dirección <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control" value="{{$customer->address}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Distrito <span class="text-danger">*</span></label>
                <select class="form-select" name="district" required>
                    <option disabled value="">Seleccione...</option>

                    @foreach ($districts as $item)

                        <option value="{{$item->name}}" {{ ( $customer->district == $item->name) ? 'selected' : '' }}>{{$item->name}}</option>

                    @endforeach

                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Referencia</label>
                <input type="text" name="address_reference" class="form-control" value="{{$customer->address_reference}}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" inputmode="numeric" pattern="[0-9]*" class="form-control" value="{{$customer->phone}}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono Alternativo</label>
                <input type="text" name="phone_two" id="phone_two" inputmode="numeric" pattern="[0-9]*" value="{{$customer->phone_two}}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{$customer->email}}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Restricción</label>
                <input type="text" name="restriction" class="form-control" value="{{$customer->restriction}}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Recomendación</label>
                <input type="text" name="recommendation" class="form-control" value="{{$customer->recommendation}}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="status" required>
                    <option value="Activo" {{ ( $customer->status == 'Activo') ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ ( $customer->status == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
                    <option value="Suspendido" {{ ( $customer->status == 'Suspendido') ? 'selected' : '' }}>Suspendido</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <a class="btn btn-secondary" href="{{  url('customer') }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
                
        </form>  
    </div>

@endsection

@section('customscripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const docType   = document.getElementById('documenttype');
    const docNumber = document.getElementById('documentnumber');
    const phone     = document.getElementById('phone');
    const form      = document.querySelector('form');

    // 👉 Ajusta reglas según tipo de documento
    function actualizarReglasDocumento() {
        if (docType.value === 'DNI') {
            docNumber.maxLength = 8;
            docNumber.minLength = 8;
            docNumber.pattern   = "\\d{8}";
        } else {
            // Ejemplo genérico: máximo 12 caracteres
            docNumber.maxLength = 12;
            docNumber.minLength = 1;
            docNumber.pattern   = ".{1,12}";
        }
        validarCampo(docNumber); // valida de inmediato al cambiar tipo
    }

    // 👉 Forzar solo dígitos y límite
    function soloDigitosYLimite(el, limite) {
        el.addEventListener('input', function (e) {
            const onlyDigits = e.target.value.replace(/\D/g, '').slice(0, limite);
            if (e.target.value !== onlyDigits) e.target.value = onlyDigits;
            validarCampo(el); // valida en vivo
        });
    }

    // 👉 Validación inmediata (Bootstrap)
    function validarCampo(input) {
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }
    }

    // Eventos iniciales
    docType.addEventListener('change', actualizarReglasDocumento);
    actualizarReglasDocumento();

    soloDigitosYLimite(docNumber, 8);
    soloDigitosYLimite(phone, 9);

    [docNumber, phone].forEach(input => {
        input.addEventListener('blur', () => validarCampo(input));
    });

    // 👉 Validación final antes de enviar
    form.addEventListener('submit', function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            form.reportValidity(); 
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });
});
</script>
@endsection
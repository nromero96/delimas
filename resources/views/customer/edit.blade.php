@extends('layouts.maintemplate')

@section('title', 'Editar Cliente')

@section('content')

    <div class="card p-3 mt-4 mb-4">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">Revise los campos marcados e inténtelo nuevamente.</div>
        @endif
        <form id="customer-form" action="{{ route('customer.update', $customer) }}" class="row" method="POST">
            @csrf
            @method('PUT')

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo Documento</label>
                <select class="form-select @error('documenttype') is-invalid @enderror" name="documenttype" id="documenttype">
                    <option disabled value="">Seleccione...</option>
                    <option value="DNI" {{ old('documenttype', $customer->document_type) === 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="CARNET EXT." {{ old('documenttype', $customer->document_type) === 'CARNET EXT.' ? 'selected' : '' }}>CARNET EXT.</option>
                    <option value="OTROS" {{ old('documenttype', $customer->document_type) === 'OTROS' ? 'selected' : '' }}>OTROS</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° Documento</label>
                <input type="text" name="documentnumber" id="documentnumber" inputmode="numeric" pattern="\d{8}" maxlength="8" class="form-control @error('documentnumber') is-invalid @enderror" value="{{ old('documentnumber', $customer->document_number) }}" data-server-invalid="{{ $errors->has('documentnumber') ? '1' : '0' }}">
                <div class="invalid-feedback" id="documentnumber-feedback">
                    @error('documentnumber')
                        {{ $message }}
                    @else
                        Ingrese un número de documento válido.
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" maxlength="255" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Dirección <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $customer->address) }}" maxlength="255" required>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Distrito <span class="text-danger">*</span></label>
                <select class="form-select @error('district') is-invalid @enderror" name="district" required>
                    <option disabled value="">Seleccione...</option>

                    @foreach ($districts as $item)

                        <option value="{{$item->name}}" {{ old('district', $customer->district) === $item->name ? 'selected' : '' }}>{{$item->name}}</option>

                    @endforeach

                </select>
                @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Referencia</label>
                <input type="text" name="address_reference" class="form-control @error('address_reference') is-invalid @enderror" value="{{ old('address_reference', $customer->address_reference) }}" maxlength="255">
                @error('address_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" inputmode="numeric" pattern="\d{9}" minlength="9" maxlength="9" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}" required>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Número de teléfono Alternativo</label>
                <input type="text" name="phone_two" id="phone_two" inputmode="numeric" pattern="\d{9}" minlength="9" maxlength="9" value="{{ old('phone_two', $customer->phone_two) }}" class="form-control @error('phone_two') is-invalid @enderror">
                @error('phone_two')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" maxlength="192">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Restricción</label>
                <input type="text" name="restriction" class="form-control @error('restriction') is-invalid @enderror" value="{{ old('restriction', $customer->restriction) }}" maxlength="2000">
                @error('restriction')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Recomendación</label>
                <input type="text" name="recommendation" class="form-control @error('recommendation') is-invalid @enderror" value="{{ old('recommendation', $customer->recommendation) }}" maxlength="2000">
                @error('recommendation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                    <option value="Activo" {{ old('status', $customer->status) === 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('status', $customer->status) === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="Suspendido" {{ old('status', $customer->status) === 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
    const phoneTwo  = document.getElementById('phone_two');
    const form      = document.getElementById('customer-form');

    // 👉 Ajusta reglas según tipo de documento
    function actualizarReglasDocumento() {
        if (docType.value === 'DNI') {
            docNumber.maxLength = 8;
            docNumber.minLength = 8;
            docNumber.pattern   = "\\d{8}";
        } else {
            docNumber.maxLength = 12;
            docNumber.minLength = 1;
            docNumber.pattern   = "[A-Za-z0-9]{1,12}";
        }
        docNumber.inputMode = docType.value === 'DNI' ? 'numeric' : 'text';
        normalizarDocumento();
    }

    // 👉 Forzar solo dígitos y límite
    function soloDigitosYLimite(el, limite) {
        el.addEventListener('input', function (e) {
            const onlyDigits = e.target.value.replace(/\D/g, '').slice(0, limite);
            if (e.target.value !== onlyDigits) e.target.value = onlyDigits;
            validarCampo(el); // valida en vivo
        });
    }

    function normalizarDocumento() {
        const limite = docType.value === 'DNI' ? 8 : 12;
        const permitido = docType.value === 'DNI' ? /\D/g : /[^A-Za-z0-9]/g;
        docNumber.value = docNumber.value.replace(permitido, '').slice(0, limite);
        validarCampo(docNumber);
    }

    // 👉 Validación inmediata (Bootstrap)
    function validarCampo(input) {
        if (input.dataset.serverInvalid === '1') {
            input.classList.add('is-invalid');
            return;
        }
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    }

    // Eventos iniciales
    docType.addEventListener('change', actualizarReglasDocumento);
    actualizarReglasDocumento();

    docNumber.addEventListener('input', function () {
        docNumber.dataset.serverInvalid = '0';
        normalizarDocumento();
    });
    soloDigitosYLimite(phone, 9);
    soloDigitosYLimite(phoneTwo, 9);

    [docNumber, phone, phoneTwo].forEach(input => {
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

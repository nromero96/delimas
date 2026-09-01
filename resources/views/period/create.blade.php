@extends('layouts.maintemplate')

@section('title', 'Crear Periodo')

@section('content')

    <div class="card shadow p-3 mt-4 mb-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">Revise los campos marcados e inténtelo nuevamente.</div>
        @endif
        <div id="period-conflict-alert" class="alert alert-warning d-none" role="alert"></div>
        <form id="period-form" action="{{ route('period.store') }}" class="row" method="POST">
            @csrf

            <div class="col-md-6">

                <div class="mb-3">
                    <label class="form-label">Programa</label>
                    @if ($selectedProgramPriceId)
                        <input type="hidden" name="idprogram" value="{{ $selectedProgramPriceId }}">
                    @endif
                    <select class="form-select @error('idprogram') is-invalid @enderror" name="{{ $selectedProgramPriceId ? '' : 'idprogram' }}" id="idprogram" {{ $selectedProgramPriceId ? 'disabled' : 'required' }}>
                        <option disabled value="" {{ old('idprogram', $selectedProgramPriceId) ? '' : 'selected' }}>Seleccione...</option>

                        @foreach ($programs as $row)
                        <option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}" data-thirtyprice="{{ $row->thirtyprice }}" {{ (int) old('idprogram', $selectedProgramPriceId) === (int) $row->id ? 'selected' : '' }}>{{ $row->programname }} / {{ $row->textcategoryprice }}</option>
                        @endforeach

                    </select>
                    @if ($selectedProgramPriceId)<div class="form-text"><i class="bi bi-lock-fill"></i> Programa de la renovación.</div>@endif
                    @error('idprogram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <div class="input-group">
                        @if ($selectedCustomerId)
                            <input type="hidden" name="idcustomer" value="{{ $selectedCustomerId }}">
                        @endif
                        <select class="form-select @error('idcustomer') is-invalid @enderror" name="{{ $selectedCustomerId ? '' : 'idcustomer' }}" {{ $selectedCustomerId ? 'disabled' : 'required' }}>
                            <option disabled value="" {{ old('idcustomer', $selectedCustomerId) ? '' : 'selected' }}>Seleccione...</option>

                            @foreach ($customers as $row)
                            <option value="{{ $row->id }}" {{ (int) old('idcustomer', $selectedCustomerId) === (int) $row->id ? 'selected' : '' }}>
                                {{ $row->name }} — {{ $row->document_number ?: 'Sin documento' }}
                            </option>
                            @endforeach

                        </select>
                        {{-- <input type="search" name="idcustomer" class="form-control" placeholder="Elija cliente" autocomplete="off" aria-label="Recipient's username" aria-describedby="button-addon2"> --}}
                        @if ($selectedCustomerId)
                            <span class="input-group-text" title="Cliente fijado"><i class="bi bi-lock-fill"></i></span>
                        @else
                            <a class="btn btn-primary" href="{{ route('customer.create') }}" title="Crear cliente"><i class="bi bi-person-plus"></i></a>
                        @endif
                    </div>
                    @error('idcustomer')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha Inicio</label>
                    <div class="input-group dvdate">
                        <input type="text" name="startdate" id="inputdatestart" class="form-control @error('startdate') is-invalid @enderror" placeholder="00-00-0000" value="{{ old('startdate') }}" autocomplete="off" aria-describedby="inputspdate" required>
                        <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>
                    </div>
                    @error('startdate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

                </div>

                <div class="mb-2">
                    <div class="bxdays text-center text-light p-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio1" value="5" {{ old('numberofdays') == 5 ? 'checked' : '' }} required>
                            <label class="form-check-label" for="quantityradio1">5 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio2" value="6" {{ old('numberofdays') == 6 ? 'checked' : '' }}>
                            <label class="form-check-label" for="quantityradio2">6 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio3" value="10" {{ old('numberofdays') == 10 ? 'checked' : '' }}>
                            <label class="form-check-label" for="quantityradio3">10 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio4" value="12" {{ old('numberofdays') == 12 ? 'checked' : '' }}>
                            <label class="form-check-label" for="quantityradio4">12 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio5" value="24" {{ old('numberofdays') == 24 ? 'checked' : '' }}>
                            <label class="form-check-label" for="quantityradio5">24 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio6" value="{{ old('numberofdays', 1) }}" {{ old('numberofdays') && !in_array((int) old('numberofdays'), [5, 6, 10, 12, 24], true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="quantityradio6">Otro</label>
                        </div>
                    </div>
                </div>
                @error('numberofdays')<div class="invalid-feedback d-block mb-2">{{ $message }}</div>@enderror

                <div class="mb-3 d-none divquantity" id="divquantity">
                    <input type="number" id="customquantity" class="form-control" min="1" max="365" value="{{ old('numberofdays', 1) }}">
                </div>

                <hr>
                <div class="card border">
                    <div class="card-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2"><h5 class="text-center mb-0">Facturación</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Cantidad menú</b></td>
                                    <td class="text-end"><span class="quantitymenu">0</span><input type="hidden" id="valquantitymenu" value="0"></td>
                                </tr>
                                <tr>
                                    <td><b>Precio unitario</b></td>
                                    <td class="text-end">S/<span id="textunitprice">0.00</span><input type="hidden" id="valunitprice" value="0"></td>
                                </tr>
                                <tr>
                                    <td><b>Precio total</b></td>
                                    <td class="text-end">S/<span id="texttotalprice">0.00</span><input type="hidden" id="valtotalprice" value="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="bxlistday p-3">
                    <h5 class="text-light">Lista Días</h5>
                    <div class="table-responsive dvtable p-3">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <th class="align-middle">DÍA</th>
                                <th class="align-middle">FECHA</th>
                                <th class="align-middle text-center" width="100px">CANTIDAD</th>
                            </thead>
                            <tbody id="tbodylistdays">
                                <tr>
                                    <td colspan="3" class="align-middle text-center">Seleccione fecha de inicio y cantidad de días.</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><b>Total</b></td>
                                    <td class="text-center"><b class="quantitymenu">0</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-12 text-end mt-3 mb-3">
                <a class="btn btn-secondary" href="{{  url('period') }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="period-submit">Agregar</button>
            </div>

        </form>
    </div>

@endsection

@section('customscripts')

<script>
    $(document).ready(function(){
        let conflictTimer;
        let conflictRequestId = 0;

        const holidays = @json($holidays);
        const datesForDisable = holidays.map(date => moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY'));


        $( "#inputdatestart" ).datepicker({
            datesDisabled: datesForDisable,
		    format: 'dd-mm-yyyy',
            autoclose: true,
            startDate: new Date(),
            language: 'es',
            daysOfWeekDisabled: [0, 6]
	    }).on("change", function() {
            generatelistdays();
        });

        $("input[name=numberofdays]").click(function () {
            if($(this).val() == '1'){
                $('#divquantity').removeClass('d-none');
            }else{
                $('#divquantity').addClass('d-none');
                $('#customquantity').val('1');
            }

            generatelistdays();

        });

        $('#customquantity').on('input', function(){
            const quantity = Math.min(365, Math.max(1, parseInt($(this).val(), 10) || 1));
            $('#quantityradio6').val(quantity);
            generatelistdays();
        });

        function countmenutotal(){
            totalmenu = 0;
            $("input[name='listcantidad[]']").each(function(){
                totalmenu += parseFloat($(this).val());
                $('.quantitymenu').text(totalmenu);
                $('#valquantitymenu').val(totalmenu);
            });
        }

        function generatelistdays(){
            $("#tbodylistdays").html('');
            const daysCount = parseInt($("input[name=numberofdays]:checked").val(), 10);
            const currentDate = moment($('#inputdatestart').val(), 'DD-MM-YYYY', true);

            if (!daysCount || !currentDate.isValid()) {
                $('#tbodylistdays').html('<tr><td colspan="3" class="text-center">Seleccione fecha de inicio y cantidad de días.</td></tr>');
                $('#valquantitymenu').val(0);
                $('.quantitymenu').text(0);
                calculateunitprice();
                clearConflictAlert();
                return;
            }

            let generated = 0;
            let rows = '';
            while (generated < daysCount) {
                const systemDate = currentDate.format('YYYY-MM-DD');
                const isWeekend = currentDate.isoWeekday() > 5;
                if (!isWeekend && !holidays.includes(systemDate)) {
                    const dayName = currentDate.locale('es').format('dddd');
                    rows += '<tr><td class="align-middle">'+dayName+'</td><td class="align-middle">'+currentDate.format('DD-MM-YYYY')+'</td><td class="align-middle"><input type="text" class="form-control text-center" value="1" readonly></td></tr>';
                    generated++;
                }
                currentDate.add(1, 'day');
            }

            $('#tbodylistdays').html(rows);
            $('.quantitymenu').text(generated);
            $('#valquantitymenu').val(generated);
            calculateunitprice();
            scheduleConflictCheck();
        }


        $('#idprogram').change(function () {
            calculateunitprice();
            scheduleConflictCheck();
        });

        $('select[name="idcustomer"]').change(scheduleConflictCheck);

        function clearConflictAlert() {
            $('#period-conflict-alert').addClass('d-none').text('');
            $('#period-submit').prop('disabled', false);
        }

        function scheduleConflictCheck() {
            clearTimeout(conflictTimer);
            conflictTimer = setTimeout(checkPeriodConflict, 300);
        }

        function checkPeriodConflict() {
            const requestId = ++conflictRequestId;
            const customerId = $('input[type="hidden"][name="idcustomer"]').val() || $('select[name="idcustomer"]').val();
            const programId = $('#idprogram').val();
            const startDate = $('#inputdatestart').val();
            const numberOfDays = $("input[name=numberofdays]:checked").val();

            if (!customerId || !programId || !startDate || !numberOfDays) {
                clearConflictAlert();
                return;
            }

            const params = new URLSearchParams({
                idcustomer: customerId,
                idprogram: programId,
                startdate: startDate,
                numberofdays: numberOfDays
            });

            fetch("{{ route('period.check-conflict') }}?" + params.toString(), {
                headers: { 'Accept': 'application/json' }
            })
                .then(response => response.ok ? response.json() : Promise.reject())
                .then(data => {
                    if (requestId !== conflictRequestId) return;
                    if (data.conflict) {
                        $('#period-conflict-alert').removeClass('d-none').text(data.message);
                        $('#period-submit').prop('disabled', true);
                    } else {
                        clearConflictAlert();
                    }
                })
                .catch(() => {
                    if (requestId === conflictRequestId) clearConflictAlert();
                });
        }

        function calculateunitprice(){
            var  quantitymenu = $('#valquantitymenu').val();

            if (!$('#idprogram').val() || quantitymenu <= 0) {
                $('#textunitprice').text('0.00');
                $('#valunitprice').val('0.00');
                totalbillingamount();
                return;
            }

            if(quantitymenu < 5){
                valueprice = $('#idprogram option:selected').attr("data-unitprice");
            }else if(quantitymenu >= 5 && quantitymenu < 10){
                valueprice = ($('#idprogram option:selected').attr("data-fiveprice") / 5).toFixed(2);
            }else if(quantitymenu >= 10 && quantitymenu < 20){
                valueprice = ($('#idprogram option:selected').attr("data-tenprice") / 10).toFixed(2);
            }else if(quantitymenu >= 30){
                valueprice = ($('#idprogram option:selected').attr("data-thirtyprice") / 30).toFixed(2);
            }else if(quantitymenu >= 20){
                valueprice = ($('#idprogram option:selected').attr("data-twentyprice") / 20).toFixed(2);
            }else{
                valueprice = 0.00;
            }
            $('#textunitprice').text(valueprice);
            $('#valunitprice').val(valueprice);
            totalbillingamount();

        }

        if ($('#quantityradio6').is(':checked')) {
            $('#divquantity').removeClass('d-none');
        }
        if ($('#inputdatestart').val() && $("input[name=numberofdays]:checked").length) {
            generatelistdays();
        }

        function totalbillingamount(){
            var unitprice = parseFloat($('#valunitprice').val());
            var valquantitymenu = parseInt($('#valquantitymenu').val());
            var calculatetotalamount = (unitprice * valquantitymenu).toFixed(2);
            $('#texttotalprice').text(calculatetotalamount);
            $('#valtotalprice').val(calculatetotalamount);
        }



    })
</script>

@endsection

@extends('layouts.maintemplate')

@section('title', 'Crear Periodo')

@section('content')

    <div class="card shadow p-3 mt-4 mb-4">
        <form action="/period" class="row" method="POST">
            @csrf

            <div class="col-md-6">

                <div class="mb-3">
                    <label class="form-label">Programa</label>
                    <select class="form-select" name="idprogram" id="idprogram" required>
                        <option selected disabled value="">Seleccione...</option>

                        @foreach ($programs as $row)
                        <option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}">{{ $row->programname }} / {{ $row->textcategoryprice }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <div class="input-group">
                        <select class="form-select" name="idcustomer" required>
                            <option selected disabled value="">Seleccione...</option>

                            @foreach ($customers as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach

                        </select>
                        {{-- <input type="search" name="idcustomer" class="form-control" placeholder="Elija cliente" autocomplete="off" aria-label="Recipient's username" aria-describedby="button-addon2"> --}}
                        <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#mdlnewcustomer"><i class="bi bi-person-plus"></i></button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha Inicio</label>
                    <div class="input-group dvdate">
                        <input type="text" name="startdate" id="inputdatestart" class="form-control" placeholder="00-00-0000" autocomplete="off" aria-describedby="inputspdate">
                        <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>
                    </div>

                </div>

                <div class="mb-2">
                    <div class="bxdays text-center text-light p-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio1" value="5">
                            <label class="form-check-label" for="quantityradio1">5 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio2" value="6">
                            <label class="form-check-label" for="quantityradio2">6 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio3" value="10">
                            <label class="form-check-label" for="quantityradio3">10 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio4" value="12">
                            <label class="form-check-label" for="quantityradio4">12 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio5" value="24">
                            <label class="form-check-label" for="quantityradio5">24 Días</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio6" value="1">
                            <label class="form-check-label" for="quantityradio6">Otro</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-none divquantity" id="divquantity">
                    <input type="text" name="customquantity" id="customquantity" class="form-control" min='1' value="1">
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
                                    <td class="text-end quantitymenu">0</td>
                                    <input type="hidden" name="valquantitymenu" id="valquantitymenu" value="0">
                                </tr>
                                <tr>
                                    <td><b>Precio unitario</b></td>
                                    <td class="text-end">S/<span id="textunitprice">0.00</span></td>
                                    <input type="hidden" name="valunitprice" id="valunitprice" value="0">
                                </tr>
                                <tr>
                                    <td><b>Precio total</b></td>
                                    <td class="text-end">S/<span id="texttotalprice">0.00</span></td>
                                    <input type="hidden" name="valtotalprice" id="valtotalprice" value="0">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="bxlistday p-3">
                    <h5 class="text-light">Lista Días</h4>
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
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>

        </form>
    </div>

    {{-- PopUp New Customer --}}

    <div class="modal fade" id="mdlnewcustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Registrar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo Docuemnto</label>
                                <select class="form-select" name="documenttype" required>
                                    <option selected disabled value="">Seleccione...</option>
                                    <option value="DNI">DNI</option>
                                    <option value="CARNET EXT.">CARNET EXT.</option>
                                    <option value="OTROS">OTROS</option>
                                </select>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <label class="form-label">N° Documento</label>
                                <input type="number" name="documentnumber" class="form-control" required>
                            </div>
                
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nombre y Apellidos</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Distrito</label>
                                <select class="form-select" name="district" required>
                                    <option selected disabled value="">Seleccione...</option>
                                    <option value="Ate">Ate</option>
                                    <option value="Ancón">Ancón</option>
                                    <option value="Comas">Comas</option>
                                </select>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de teléfono</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="Inactivo">
                                    <input class="form-check-input" type="checkbox" name="status" id="statuscustomer" value="Activo" checked>
                                    <label class="form-check-label" for="statuscustomer"> Estado</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End PopUp New Customer --}}

@endsection

@section('customscripts')

<script>
    $(document).ready(function(){

        var datesForDisable; /*Feridos con formato DD-MM-YYYY*/
        var holidays; /*Feridos con formato YYYY-MM-DD*/


        $.ajax({
            url: '/holiday-listholidays',
            method: 'GET',
            async: false,
            success : function(res) {
                var obj = jQuery.parseJSON(res);
                var a=[];
                var b=[];
                $.each(obj, function(key,value) {
                    a.push(moment(value.date).format('DD-MM-YYYY'));
                    b.push(moment(value.date).format('YYYY-MM-DD'));
                });
                datesForDisable = a;
                holidays = b;
            }
        });


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

        $('#customquantity').keyup(function(){
            $('#quantityradio6').val($(this).val());
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
            var days_count = $("input[name=numberofdays]:checked").val();
            let getdateinput = $('#inputdatestart').val();
            let dateinputorganize = moment(getdateinput, 'DD-MM-YYYY');
            let formatdatesistem = dateinputorganize.format('YYYY-MM-DD');

                var vardate = new Date(formatdatesistem);
                vardate.setDate(vardate.getDate() + 1);

                var dias = parseInt(days_count);
                $i = 1;
                foundholiday = 0;
                trdate = '';

                while ($i <= dias) {

                    resultnameday = moment(vardate).format('dddd');
                    resultdateview = moment(vardate).format('DD-MM-YYYY');
                    if(resultnameday =='Sabado' || resultnameday =='Domingo'){
                        vardate.setDate(vardate.getDate() + 1);
                    }else{
                        foundholiday = 0;
                        for (const element of holidays) {
                            resformatdate = moment(vardate).format('YYYY-MM-DD');
                            if(element == resformatdate){
                                foundholiday = 1;
                                break;
                            }else{

                            }
                        }

                        if(foundholiday == 0){
                            trdate += '<tr><td class="align-middle">'+resultnameday+' <input type="hidden" name="listdayname[]" value="'+resultnameday+'"></td><td class="align-middle">'+resultdateview+'<input type="hidden" name="listdate[]" value="'+resformatdate+'"></td><td class="align-middle"> <input type="text" name="listcantidad[]" class="form-control text-center" value="1" readonly> </td></tr>';
                            vardate.setDate(vardate.getDate() + 1);
                            $i++;
                        } else {
                            vardate.setDate(vardate.getDate() + 1);
                        }
                    }

                }

                $('#tbodylistdays').html(trdate);
                countmenutotal();
                calculateunitprice();
                totalbillingamount();
        }


        $('#idprogram').change(function () {
            calculateunitprice();
        });

        function calculateunitprice(){
            var  quantitymenu = $('#valquantitymenu').val();

            if(quantitymenu < 5){
                valueprice = $('#idprogram option:selected').attr("data-unitprice");
            }else if(quantitymenu >= 5 && quantitymenu < 9){
                valueprice = ($('#idprogram option:selected').attr("data-fiveprice") / 5).toFixed(2);
            }else if(quantitymenu >= 10 && quantitymenu < 19){
                valueprice = ($('#idprogram option:selected').attr("data-tenprice") / 10).toFixed(2);
            }else if(quantitymenu >= 20){
                valueprice = ($('#idprogram option:selected').attr("data-twentyprice") / 20).toFixed(2);
            }else{
                valueprice = 0.00;
            }
            $('#textunitprice').text(valueprice);
            $('#valunitprice').val(valueprice);
            totalbillingamount();

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
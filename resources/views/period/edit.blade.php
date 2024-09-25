@extends('layouts.maintemplate')

@section('title', 'Editar Periodo')

@section('content')

    <div class="card shadow p-3 mt-4 mb-4">
        <form action="/period/{{$period->id}}" class="row" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6">

                @php
                    $dateliststart = Carbon\Carbon::parse($period->start_date);
                    $nowdate = Carbon\Carbon::now();
                    $convertformat = $nowdate->format('Y-m-d');
                    $diffdays = $dateliststart->diffInDays($nowdate);
                @endphp

                <div class="mb-3">
                    <label class="form-label">Programa</label>


                    @if ($period->start_date < $convertformat)
                        <select class="form-select" name="idprogram" id="idprogram" required>
                            @foreach ($programs as $row)
                                @if( $row->id == $period->id_programprice )
                                    <option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}" {{ ( $row->id == $period->id_programprice) ? 'selected' : '' }}>{{ $row->programname }} / {{ $row->textcategoryprice }}</option>
                                @endif
                            @endforeach
                        </select>
                    @else 
                        <select class="form-select" name="idprogram" id="idprogram" required>
                            <option selected disabled value="">Seleccione...</option>
                            @foreach ($programs as $row)
                                <option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}" {{ ( $row->id == $period->id_programprice) ? 'selected' : '' }}>{{ $row->programname }} / {{ $row->textcategoryprice }}</option>
                            @endforeach
                        </select>
                    @endif



                </div>

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <div class="input-group">
                        
                        <input type="text" name="idcustomer" class="form-control" placeholder="Elija cliente" value="{{$customer->name}}" readonly>
                        
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha Inicio</label>

                    <div class="input-group dvdate">

                    @if ($period->start_date < $convertformat)
                        <input type="text" name="startdate" class="form-control" value="{{ Carbon\Carbon::parse($period->start_date)->format('d-m-Y') }}" aria-describedby="inputspdate" readonly>
                    @else 
                        <input type="text" name="startdate" id="inputdatestart" class="form-control" placeholder="00-00-0000" value="{{ Carbon\Carbon::parse($period->start_date)->format('d-m-Y') }}" autocomplete="off" aria-describedby="inputspdate"> 
                    @endif
                        <span class="input-group-text" id="inputspdate"><i class="bi bi-calendar2-week"></i></span>

                    </div>

                </div>

                @if ($period->start_date < $convertformat)
                    <div class="mb-3">
                        <p><b>{{ $period->number_of_days }}</b> días</p>
                        <input type="hidden" name="numberofdays" id="numberofdays" value="{{ $period->number_of_days }}">
                    </div>
                @else 
                    <div class="mb-2">
                        <div class="bxdays text-center text-light p-2">
                            @php
                                $arraydias = ['5','6','10','12','24'];                                    
                            @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio1" value="5" {{ ( $period->number_of_days == '5') ? 'checked' : '' }} >
                                <label class="form-check-label" for="quantityradio1">5 Días</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio2" value="6" {{ ( $period->number_of_days == '6') ? 'checked' : '' }}>
                                <label class="form-check-label" for="quantityradio2">6 Días</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio3" value="10" {{ ( $period->number_of_days == '10') ? 'checked' : '' }}>
                                <label class="form-check-label" for="quantityradio3">10 Días</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio4" value="12" {{ ( $period->number_of_days == '12') ? 'checked' : '' }}>
                                <label class="form-check-label" for="quantityradio4">12 Días</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio5" value="24" {{ ( $period->number_of_days == '24') ? 'checked' : '' }}>
                                <label class="form-check-label" for="quantityradio5">24 Días</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="numberofdays" id="quantityradio6" value="1" {{ ( !in_array($period->number_of_days, $arraydias)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="quantityradio6">Otro</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 {{ ( !in_array($period->number_of_days, $arraydias)) ? '' : 'd-none' }} divquantity" id="divquantity">
                        <input type="text" name="customquantity" id="customquantity" class="form-control" min='1' value="{{ ( !in_array($period->number_of_days, $arraydias)) ? $period->number_of_days : '1' }}">
                    </div>
                @endif

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
                                    <td class="text-end quantitymenu">{{$period->quantity_of_menu}}</td>
                                    <input type="hidden" name="valquantitymenu" id="valquantitymenu" value="{{$period->quantity_of_menu}}">
                                </tr>
                                <tr>
                                    <td><b>Precio unitario</b></td>
                                    <td class="text-end">S/<span id="textunitprice">{{$period->unitprice_moment}}</span></td>
                                    <input type="hidden" name="valunitprice" id="valunitprice" value="{{$period->unitprice_moment}}">
                                </tr>
                                <tr>
                                    <td><b>Precio total</b></td>
                                    <td class="text-end">S/<span id="texttotalprice">{{$period->total_price}}</span></td>
                                    <input type="hidden" name="valtotalprice" id="valtotalprice" value="{{$period->total_price}}">
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
                                @foreach ($perioddays as $row)
                                    @php
                                        $d    = new DateTime($row->date);
                                        if($row->date < $convertformat){
                                            $inpuquantityedit = '<input type="hidden" name="listcantidad[]" value="'.$row->quantity.'">'.$row->quantity.'';
                                        }else{
                                            $inpuquantityedit = '<input type="text" name="listcantidad[]" class="form-control onlyspecificnumbers text-center" value="'.$row->quantity.'" maxlength="1">';
                                        }

                                        if($row->date == $convertformat){

                                            $classrowactive = 'trdayactive';
                                        } else {
                                            $classrowactive = '';
                                        }
                                    @endphp

                                    <tr class="{{ $classrowactive }}"><td class="align-middle">{{$row->dayname}} <input type="hidden" name="listdayname[]" value="{{$row->dayname}}"></td><td class="align-middle">{{$d->format('d-m-Y');}}<input type="hidden" name="listdate[]" value="{{$row->date}}"></td><td class="align-middle text-center"> <?= $inpuquantityedit ?> </td></tr>
                                
                                @endforeach
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
                <a class="btn btn-secondary" href="{{ url()->previous() }}" role="button">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
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

        $('input[type=text]').bind('copy paste', function (e) {e.preventDefault();});
        $('.onlyspecificnumbers').keyup(function (){ this.value = (this.value + '').replace(/[^0-1]/g, '0');});
        $('.onlyspecificnumbers').keydown( function (event) { if (event.which == 8 || event.which == 46) { event.preventDefault(); } });
        $('.onlyspecificnumbers').click(function (){ this.select(); });


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

        countmenutotal();

        $( "#inputdatestart" ).datepicker({
		    format: 'dd-mm-yyyy',
            autoclose: true,
            datesDisabled: datesForDisable,
            startDate: new Date(),
            language: 'en',
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



        $("input[name='listcantidad[]']").keyup(function(){

            countmenutotal();
            var valuedata = $(this).val();
            var numberdays = parseInt($('#numberofdays').val());
            var quantitymenu = parseInt($('#valquantitymenu').val());

            var fechaultimo = $("input[name='listdate[]']").last().val();

            if(valuedata == 0 && quantitymenu < numberdays){
                generateoneday(fechaultimo, 1);
            } else if(valuedata == 1 &&  quantitymenu > numberdays ) {
                $("#tbodylistdays tr:last-child").after().remove();
            } else {

            }
            countmenutotal();

        });

        function countmenutotal(){
            totalmenu = 0;
            $("input[name='listcantidad[]']").each(function(){
                totalmenu += parseFloat($(this).val());
                $('.quantitymenu').text(totalmenu);
                $('#valquantitymenu').val(totalmenu);
            });
        }

        function generateoneday(lastdate, quantitydays){

            var days_count = quantitydays;

            var vardate = new Date(lastdate);

            vardate.setDate(vardate.getDate() + 2);

            var dias = parseInt(days_count); 
                
            $i = 1;
            foundholiday = 0;
            trdate = '';

            while ($i <= dias) {

                    resultnameday = moment(vardate).format('dddd');
                    resultdateview = moment(vardate).format('DD-MM-YYYY');
                    
                    if(resultnameday =='Sabado' || resultnameday =='Domingo'){
                        vardate.setDate(vardate.getDate() + 2);
                    }else{
                        foundholiday = 0;
                        for (const element of holidays) {
                            resformatdate = moment(vardate).format('YYYY-MM-DD');
                            if(element == resformatdate){
                                foundholiday = 2;
                                break;
                            }else{
                            
                            }
                        }

                        if(foundholiday == 0){
                            trdate += '<tr><td class="align-middle">'+resultnameday+' <input type="hidden" name="listdayname[]" value="'+resultnameday+'"></td><td class="align-middle">'+resultdateview+'<input type="hidden" name="listdate[]" value="'+resformatdate+'"></td><td class="align-middle"> <input type="text" name="listcantidad[]" class="form-control text-center" value="1" readonly> </td></tr>';
                            vardate.setDate(vardate.getDate() + 2);
                            $i++; 
                        } else {
                            vardate.setDate(vardate.getDate() + 2);
                        }
                    }

            }

            $("#tbodylistdays tr:last-child").after(trdate);

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
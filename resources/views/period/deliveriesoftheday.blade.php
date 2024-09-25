@extends('layouts.maintemplate')

@section('title', 'Lista de entregas del día')

@section('buttonsarea')
<a href="{{ route('download-entry-control') }}?filterbyprogram={{ Request::get('filterbyprogram') }}&filterbycustomer={{ Request::get('filterbycustomer') }}&filterbydate={{ Request::get('filterbydate') }}" target="_blank" class="btn btn-info text-light" role="button"><i class="bi bi-file-earmark-pdf"></i> Control de Entrega</a>
    <a href="{{ route('download-stickers') }}?filterbyprogram={{ Request::get('filterbyprogram') }}&filterbycustomer={{ Request::get('filterbycustomer') }}&filterbydate={{ Request::get('filterbydate') }}" target="_blank" class="btn btn-danger mx-2" role="button"><i class="bi bi-file-earmark-pdf"></i> Stickers</a>
    <a href="{{  url('period/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection





@section('content')

<div class="row mt-4 mb-4">

    <div class="col-md-12">
        <marquee behavior="" direction="">
            <img src="{{ asset('/images/moto-delivery.png')}}" class="moticon" alt="...">
        </marquee>

        <div class="card shadow">
            <div class="card-header border-bottom d-flex align-items-center">

                @php
                    if(Request::get('filterbydate')==''){
                        $datetext = '<em class="datedelday">'. Carbon\Carbon::now()->format('d-m-Y') .'</em>';
                    }else{
                        $datetext = '<em class="datedelday">'.Request::get('filterbydate').'</em>';
                    }
                @endphp

                <h5 class="me-auto">Lista de entregas para <?= $datetext ?></h5>
                <div class="">
                    <form action="" method="GET" class="d-flex">
                        <input type="text" name="filterbyprogram" class="form-control mx-2" value="{{ Request::get('filterbyprogram') }}" placeholder="Buscar por programa...">
                        <input type="text" name="filterbycustomer" class="form-control mx-2" value="{{ Request::get('filterbycustomer') }}" placeholder="Buscar por cliente...">
                        <input type="text" name="filterbydate" id="inputsearchdate" value="{{ Request::get('filterbydate') }}" autocomplete="off" class="form-control mx-2" placeholder="Buscar por fecha...">
                        <button type="submit" class="btn btn-secondary text-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">PROGRAMA</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col" class="text-center">UNIDAD</th>
                            <th scope="col">FECHA</th>
                            <th scope="col" width="105px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($perioddays as $row)
                        <tr style="background:{{$row->programcolor}} ">

                            <td>{{ $row->programname }} / {{ $row->textcategoryprice}}</td>
                            <td>{{ $row->customername }}</td>
                            <td class="text-center">{{ $row->quantity }}</td>
                            <td>{{ Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                            <td>
                                <div class="btnsaction">
                                    <a href="javascript:void(0)" class="btn btn-light pt-0 pb-0 show-customer" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#mdldetailcustomer" data-url="{{ route('customers.showinfocustomer', $row->customerid) }}"><i class="bi bi-person-lines-fill"></i></a> 
                                    <a href="/period/{{ $row->periodsid }}/edit" class="btn btn-light pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                <div class="d-flex justify-content-center">
                    {!! $perioddays->links() !!}
                </div>

            </div>
        </div>

    </div>

</div>



{{-- PopUp detail Customer --}}

<div class="modal fade" id="mdldetailcustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información del cliente</h5>
                    <button type="button" class="btn-close" id="btnclosemdinfo" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tipo Docuemnto</label><br>
                            <span id="customer-document_type" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label>N° Documento</label><br>
                            <span id="customer-document_number" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-12 mb-3">
                            <label>Nombre y Apellidos</label><br>
                            <span id="customer-name" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label>Dirección</label><br>
                            <span id="customer-address" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label>Distrito</label><br>
                            <span id="customer-district" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-1">
                            <label>Número de teléfono</label><br>
                            <span id="customer-phone" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-1">
                            <label>Correo electrónico</label><br>
                            <span id="customer-email" class="infospan">...</span>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer"> </div>
            </form>
        </div>
    </div>
</div>

{{-- End PopUp detail Customer --}}




@endsection


@section('customscripts')

<script>
    $(document).ready(function(){

        $("#inputsearchdate").datepicker({
		    format: 'dd-mm-yyyy',
            autoclose: true,
            language: 'es',
            todayHighlight: true
	    })


        /* When click show user */
        $('body').on('click', '.show-customer', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#mdldetailcustomer').modal('show');
                $('#customer-document_type').text(data.document_type);
                $('#customer-document_number').text(data.document_number);
                $('#customer-name').text(data.name);
                $('#customer-address').text(data.address);
                $('#customer-district').text(data.district);
                $('#customer-phone').text(data.phone);
                $('#customer-email').text(data.email);
            })
        });

        $('#btnclosemdinfo').click(function(){
            $('#customer-document_type').text('...');
            $('#customer-document_number').text('...');
            $('#customer-name').text('...');
            $('#customer-address').text('...');
            $('#customer-district').text('...');
            $('#customer-phone').text('...');
            $('#customer-email').text('...');
        });
        
    

    })
</script>

@endsection
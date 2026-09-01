@extends('layouts.maintemplate')

@section('title', 'Lista de entregas del día')

@section('buttonsarea')
<a href="{{ route('download-entry-control', request()->only(['filterbyprogram', 'filterbycustomer', 'filterbydate'])) }}" target="_blank" class="btn btn-info text-light" role="button"><i class="bi bi-file-earmark-pdf"></i> Control de Entrega</a>
    <a href="{{ route('download-stickers', request()->only(['filterbyprogram', 'filterbycustomer', 'filterbydate'])) }}" target="_blank" class="btn btn-danger mx-2" role="button"><i class="bi bi-file-earmark-pdf"></i> Stickers</a>
    <a href="{{  url('period/create') }}" class="btn btn-primary" role="button"><i class="bi bi-plus-circle"></i> Agregar nuevo</a>
@endsection





@section('content')

<div class="row mt-4 mb-4">
    @if (session('delivery_filter_error'))
        <div class="col-12"><div class="alert alert-danger">{{ session('delivery_filter_error') }}</div></div>
    @endif

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex flex-wrap align-items-center gap-3">
                <h5 class="me-auto mb-0">Entregas para <em class="datedelday">{{ Carbon\Carbon::parse($datefilter)->format('d-m-Y') }}</em></h5>
                <div>
                    <form action="{{ route('deliveriesoftheday') }}" method="GET" class="d-flex flex-wrap gap-2 justify-content-end">
                        <input type="search" name="filterbyprogram" class="form-control w-auto" value="{{ request('filterbyprogram') }}" placeholder="Programa...">
                        <input type="search" name="filterbycustomer" class="form-control w-auto" value="{{ request('filterbycustomer') }}" placeholder="Cliente o documento...">
                        <input type="text" name="filterbydate" id="inputsearchdate" value="{{ request('filterbydate') }}" autocomplete="off" class="form-control w-auto" placeholder="Fecha...">
                        <button type="submit" class="btn btn-secondary text-light" title="Buscar"><i class="bi bi-search"></i></button>
                        @if (request()->hasAny(['filterbyprogram', 'filterbycustomer', 'filterbydate']))
                            <a href="{{ route('deliveriesoftheday') }}" class="btn btn-outline-secondary" title="Limpiar filtros"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">PROGRAMA</th>
                            <th scope="col">CLIENTE / DOCUMENTO</th>
                            <th scope="col">DIRECCIÓN DE ENTREGA</th>
                            <th scope="col">CONTACTO</th>
                            <th scope="col" class="text-center">CANTIDAD</th>
                            <th scope="col">FECHA</th>
                            <th scope="col" width="105px">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($perioddays as $row)
                        <tr>
                            <td><span class="d-inline-block rounded-circle me-2" style="width:14px;height:14px;background:{{ $row->programcolor }}"></span>{{ $row->programname }}<div class="small text-muted">{{ $row->textcategoryprice }}</div></td>
                            <td>{{ $row->customername }}<div class="small text-muted">{{ $row->customerdocument ?: 'Sin documento' }}</div></td>
                            <td>{{ $row->customeraddress }}<div class="small text-muted">{{ $row->customerdistrict }}@if($row->customeraddressreference) · Ref. {{ $row->customeraddressreference }}@endif</div></td>
                            <td><a href="tel:{{ $row->customerphone }}">{{ $row->customerphone }}</a></td>
                            <td class="text-center">{{ $row->quantity }}</td>
                            <td>{{ Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                            <td>
                                <div class="btnsaction">
                                    <a href="javascript:void(0)" class="btn btn-light pt-0 pb-0 show-customer" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#mdldetailcustomer" data-url="{{ route('customers.showinfocustomer', $row->customerid) }}"><i class="bi bi-person-lines-fill"></i></a> 
                                    <a href="/period/{{ $row->periodsid }}/edit" class="btn btn-light pt-0 pb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">No hay entregas programadas para la fecha y filtros seleccionados.</td></tr>
                        @endforelse

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
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Información del cliente</h5>
                    <button type="button" class="btn-close" id="btnclosemdinfo" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="customer-detail-error" class="alert alert-danger d-none">No se pudo cargar la información del cliente.</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tipo Documento</label><br>
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

                        <div class="col-md-12 mb-3">
                            <label>Referencia</label><br>
                            <span id="customer-address_reference" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label>Número de teléfono</label><br>
                            <span id="customer-phone" class="infospan">...</span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Teléfono alternativo</label><br>
                            <span id="customer-phone_two" class="infospan">...</span>
                        </div>
            
                        <div class="col-md-12 mb-1">
                            <label>Correo electrónico</label><br>
                            <span id="customer-email" class="infospan">...</span>
                        </div>

                        <div class="col-md-12 mt-3 mb-1">
                            <label>Restricción</label><br>
                            <span id="customer-restriction" class="infospan">...</span>
                        </div>

                        <div class="col-md-12 mt-3 mb-1">
                            <label>Recomendación</label><br>
                            <span id="customer-recommendation" class="infospan">...</span>
                        </div>

                        <div class="col-md-12 mt-3 mb-1">
                            <label>Estado</label><br>
                            <span id="customer-status" class="infospan">...</span>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer"> </div>
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
            $('#customer-detail-error').addClass('d-none');
            $.get(userURL, function (data) {
                $('#mdldetailcustomer').modal('show');
                $('#customer-document_type').text(data.document_type);
                $('#customer-document_number').text(data.document_number);
                $('#customer-name').text(data.name);
                $('#customer-address').text(data.address);
                $('#customer-district').text(data.district);
                $('#customer-address_reference').text(data.address_reference);
                $('#customer-phone').text(data.phone);
                $('#customer-phone_two').text(data.phone_two || 'No registrado');
                $('#customer-email').text(data.email || 'No registrado');
                $('#customer-restriction').text(data.restriction || 'Sin restricciones');
                $('#customer-recommendation').text(data.recommendation || 'Sin recomendaciones');
                $('#customer-status').text(data.status);
            }).fail(function () {
                $('#customer-detail-error').removeClass('d-none');
            });
        });

        $('#btnclosemdinfo').click(function(){
            $('#customer-document_type').text('...');
            $('#customer-document_number').text('...');
            $('#customer-name').text('...');
            $('#customer-address').text('...');
            $('#customer-district').text('...');
            $('#customer-address_reference').text('...');
            $('#customer-phone').text('...');
            $('#customer-phone_two').text('...');
            $('#customer-email').text('...');
            $('#customer-restriction').text('...');
            $('#customer-recommendation').text('...');
            $('#customer-status').text('...');
            $('#customer-detail-error').addClass('d-none');
        });
        
    

    })
</script>

@endsection

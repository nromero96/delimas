@extends('layouts.maintemplate')
@section('title', 'Editar registro diario')
@section('content')
@include('period._form_styles')
<div class="card shadow p-3 mt-4 mb-4">
 @if ($errors->any())<div class="alert alert-danger">Revise los campos marcados e inténtelo nuevamente.</div>@endif
 <form id="period-form" action="{{ route('period.update', $period) }}" class="row" method="POST">@csrf @method('PUT')
  <div class="col-lg-5">
   <div class="mb-3"><label class="form-label">Programa</label><select class="form-select" name="idprogram" id="idprogram" required>@foreach($programs as $row)<option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}" data-thirtyprice="{{ $row->thirtyprice }}" {{ (int)old('idprogram',$period->id_programprice)===(int)$row->id?'selected':'' }}>{{ $row->programname }} / {{ $row->textcategoryprice }}</option>@endforeach</select></div>
   <div class="mb-3"><label class="form-label">Cliente</label><input class="form-control" value="{{ $customer->name }} — {{ $customer->document_number }}" disabled><div class="form-text">El cliente no cambia al editar un registro.</div></div>
   <div id="customer-history" class="alert alert-light border small"></div>
   <div class="mb-3"><label class="form-label">Fecha de inicio</label><input type="text" name="startdate" id="inputdatestart" class="form-control" value="{{ old('startdate', Carbon\Carbon::parse($period->start_date)->format('d-m-Y')) }}" readonly></div>
   <input type="hidden" name="numberofdays" id="numberofdays" value="{{ old('numberofdays', $perioddays->count()) }}">
   <button class="btn btn-outline-success billing-toggle mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#billing"><i class="bi bi-receipt"></i> Facturación</button>
   <div class="collapse show" id="billing"><div class="card card-body billing-card"><div class="billing-card__title"><i class="bi bi-cash-coin"></i> Resumen de facturación</div><label class="form-label">Cantidad total de menús</label><input id="valquantitymenu" class="form-control mb-2" readonly><label class="form-label">Precio unitario (S/)</label><input type="number" step="0.01" min="0" name="valunitprice" id="valunitprice" class="form-control mb-2" value="{{ old('valunitprice', $period->unitprice_moment) }}" required><label class="form-label">Precio total (S/)</label><input type="number" step="0.01" min="0" name="valtotalprice" id="valtotalprice" class="form-control" value="{{ old('valtotalprice', $period->total_price) }}" required><div class="form-text mt-2"><i class="bi bi-info-circle"></i> Los importes pueden ajustarse manualmente.</div></div></div>
  </div>
  <div class="col-lg-7"><div class="period-form-panel"><div class="period-form-panel__header"><i class="bi bi-calendar2-week"></i><h5>Programación diaria</h5></div><div class="period-form-panel__body"><div class="table-responsive"><table class="table table-sm align-middle period-schedule-table"><thead><tr><th>Día</th><th>Fecha editable</th><th style="width:130px">Menús</th></tr></thead><tbody id="tbodylistdays">@foreach($perioddays as $day)<tr><td class="day-name">{{ $day->dayname }}</td><td><input type="date" name="listdate[]" class="form-control form-control-sm day-date" value="{{ old('listdate.'.$loop->index, Carbon\Carbon::parse($day->date)->format('Y-m-d')) }}" required></td><td><input type="number" name="listcantidad[]" class="form-control form-control-sm day-qty" min="0" max="999" value="{{ old('listcantidad.'.$loop->index, $day->quantity) }}" required></td></tr>@endforeach</tbody></table></div><div class="form-text"><i class="bi bi-pencil-square"></i> Puede ajustar las fechas y cantidades antes de actualizar.</div></div></div></div>
  <div class="col-12 text-end mt-3"><a href="{{ route('period.index') }}" class="btn btn-secondary">Cancelar</a> <button class="btn btn-primary" type="submit">Actualizar</button> <button class="btn btn-outline-danger" type="submit" form="cancel-period-form" onclick="return confirm('¿Anular este período?')">Anular</button></div>
 </form>
 <form id="cancel-period-form" action="{{ route('period.cancel',$period) }}" method="POST" class="d-none">@csrf @method('PATCH')</form>
</div>
@endsection
@section('customscripts')
<script>
$(function(){
 function total(){let n=0;$('.day-qty').each(function(){n+=Number(this.value||0)});$('#valquantitymenu').val(n);return n}
 $('#tbodylistdays').on('input change','input',function(){const m=moment($(this).closest('tr').find('.day-date').val(),'YYYY-MM-DD',true);if(m.isValid())$(this).closest('tr').find('.day-name').text(m.locale('es').format('dddd'));$('#numberofdays').val($('.day-date').length);total()}); total();
 $('#valunitprice').on('input',function(){$('#valtotalprice').val((Number(this.value||0)*total()).toFixed(2))});
 $.get('{{ route('period.customer-history',$customer) }}').done(rows=>$('#customer-history').html('<strong>Historial del cliente</strong><ul class="mb-0">'+rows.map(r=>`<li>${r.programname} / ${r.textcategoryprice}: ${moment(r.start_date).format('DD-MM-YYYY')} a ${moment(r.end_date).format('DD-MM-YYYY')} (${r.status})</li>`).join('')+'</ul>'));
});
</script>
@endsection

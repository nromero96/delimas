@extends('layouts.maintemplate')
@section('title', 'Crear registro diario')
@section('content')
@include('period._form_styles')
<div class="card shadow p-3 mt-4 mb-4">
 @if ($errors->any())<div class="alert alert-danger">Revise los campos marcados e inténtelo nuevamente.</div>@endif
 <div id="period-conflict-alert" class="alert alert-warning d-none"></div>
 <form id="period-form" action="{{ route('period.store') }}" class="row" method="POST">@csrf
  <div class="col-lg-5">
   <div class="mb-3"><label class="form-label">Programa <span class="text-danger">*</span></label>
    @if ($selectedProgramPriceId)<input type="hidden" name="idprogram" value="{{ $selectedProgramPriceId }}">@endif
    <select class="form-select @error('idprogram') is-invalid @enderror" name="{{ $selectedProgramPriceId ? '' : 'idprogram' }}" id="idprogram" {{ $selectedProgramPriceId ? 'disabled' : 'required' }}><option disabled value="" {{ old('idprogram', $selectedProgramPriceId) ? '' : 'selected' }}>Seleccione...</option>@foreach ($programs as $row)<option value="{{ $row->id }}" data-unitprice="{{ $row->oneprice }}" data-fiveprice="{{ $row->fiveprice }}" data-tenprice="{{ $row->tenprice }}" data-twentyprice="{{ $row->twentyprice }}" data-thirtyprice="{{ $row->thirtyprice }}" {{ (int) old('idprogram', $selectedProgramPriceId) === (int) $row->id ? 'selected' : '' }}>{{ $row->programname }} / {{ $row->textcategoryprice }}</option>@endforeach</select>
    @if ($selectedProgramPriceId)<div class="form-text"><i class="bi bi-lock-fill"></i> Programa de la renovación.</div>@endif @error('idprogram')<div class="invalid-feedback">{{ $message }}</div>@enderror
   </div>
   <div class="mb-3"><label class="form-label">Cliente <span class="text-danger">*</span></label><div class="input-group">
    @if ($selectedCustomerId)<input type="hidden" name="idcustomer" value="{{ $selectedCustomerId }}">@endif
    <select class="form-select @error('idcustomer') is-invalid @enderror" id="idcustomer" name="{{ $selectedCustomerId ? '' : 'idcustomer' }}" {{ $selectedCustomerId ? 'disabled' : 'required' }}><option disabled value="" {{ old('idcustomer', $selectedCustomerId) ? '' : 'selected' }}>Seleccione...</option>@foreach ($customers as $row)<option value="{{ $row->id }}" {{ (int) old('idcustomer', $selectedCustomerId) === (int) $row->id ? 'selected' : '' }}>{{ $row->name }} — {{ $row->document_number }}</option>@endforeach</select>
    @if ($selectedCustomerId)<span class="input-group-text" title="Cliente fijado"><i class="bi bi-lock-fill"></i></span>@else<a class="btn btn-primary" href="{{ route('customer.create') }}"><i class="bi bi-person-plus"></i></a>@endif
   </div>@error('idcustomer')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
   <div id="customer-history" class="alert alert-light border small d-none"></div>
   <div class="mb-3"><label class="form-label">Fecha de inicio <span class="text-danger">*</span></label><input type="text" name="startdate" id="inputdatestart" class="form-control @error('startdate') is-invalid @enderror" placeholder="dd-mm-aaaa" value="{{ old('startdate') }}" autocomplete="off" required>@error('startdate')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
   <div class="mb-3"><label class="form-label d-block">Plan contratado</label>@foreach ([5 => '5 días', 11 => '10 + 1 días', 22 => '20 + 2 días', 35 => '30 + 5 días'] as $value => $label)<div class="form-check form-check-inline"><input class="form-check-input plan-days" type="radio" name="numberofdays" id="days{{ $value }}" value="{{ $value }}" {{ (int) old('numberofdays') === $value ? 'checked' : '' }} required><label class="form-check-label" for="days{{ $value }}">{{ $label }}</label></div>@endforeach @error('numberofdays')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
   <button class="btn btn-outline-success billing-toggle mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#billing"><i class="bi bi-receipt"></i> Facturación</button>
   <div class="collapse show" id="billing"><div class="card card-body billing-card mb-3"><div class="billing-card__title"><i class="bi bi-cash-coin"></i> Resumen de facturación</div><label class="form-label">Cantidad total de menús</label><input id="valquantitymenu" class="form-control mb-2" value="0" readonly><label class="form-label">Precio unitario (S/)</label><input type="number" step="0.01" min="0" name="valunitprice" id="valunitprice" class="form-control mb-2" value="{{ old('valunitprice', '0.00') }}" required><label class="form-label">Precio total (S/)</label><input type="number" step="0.01" min="0" name="valtotalprice" id="valtotalprice" class="form-control" value="{{ old('valtotalprice', '0.00') }}" required><div class="form-text mt-2"><i class="bi bi-info-circle"></i> Los importes se calculan como referencia y pueden ajustarse manualmente.</div></div></div>
  </div>
  <div class="col-lg-7"><div class="period-form-panel"><div class="period-form-panel__header"><i class="bi bi-calendar2-week"></i><h5>Programación diaria</h5></div><div class="period-form-panel__body"><div class="table-responsive"><table class="table table-sm align-middle period-schedule-table"><thead><tr><th>Día</th><th>Fecha editable</th><th style="width:130px">Menús</th></tr></thead><tbody id="tbodylistdays"><tr><td colspan="3" class="text-center text-muted py-4">Seleccione fecha y plan.</td></tr></tbody></table></div><div class="form-text"><i class="bi bi-pencil-square"></i> Puede modificar cada fecha y la cantidad de menús antes de guardar.</div></div></div></div>
  <div class="col-12 text-end mt-3"><a class="btn btn-secondary" href="{{ route('period.index') }}">Cancelar</a> <button type="submit" class="btn btn-primary" id="period-submit">Agregar</button></div>
 </form>
</div>
@endsection
@section('customscripts')
<script>
$(function(){
 const holidays=@json($holidays); let manual=false;
 $('#inputdatestart').datepicker({format:'dd-mm-yyyy',autoclose:true,startDate:new Date(),language:'es',daysOfWeekDisabled:[0,6],datesDisabled:holidays.map(d=>moment(d).format('DD-MM-YYYY'))}).on('change',generate);
 $('.plan-days').on('change',generate); $('#idprogram').on('change',function(){manual=false;billing();conflict()}); $('#idcustomer').on('change',function(){history();conflict()});
 $('#valunitprice').on('input',function(){manual=true;$('#valtotalprice').val((Number(this.value||0)*total()).toFixed(2))}); $('#valtotalprice').on('input',()=>manual=true);
 $('#tbodylistdays').on('input change','input',function(){const tr=$(this).closest('tr'),m=moment(tr.find('.day-date').val(),'YYYY-MM-DD',true);if(m.isValid())tr.find('.day-name').text(m.locale('es').format('dddd'));billing();conflict()});
 function generate(){const n=Number($('.plan-days:checked').val()),start=moment($('#inputdatestart').val(),'DD-MM-YYYY',true);if(!n||!start.isValid())return;let html='',made=0,d=start.clone();while(made<n){const iso=d.format('YYYY-MM-DD');if(d.isoWeekday()<6&&!holidays.includes(iso)){html+=`<tr><td class="day-name">${d.locale('es').format('dddd')}</td><td><input type="date" name="listdate[]" class="form-control form-control-sm day-date" value="${iso}" required></td><td><input type="number" name="listcantidad[]" class="form-control form-control-sm day-qty" min="0" max="999" value="1" required></td></tr>`;made++}d.add(1,'day')}$('#tbodylistdays').html(html);manual=false;billing();conflict()}
 function total(){let n=0;$('.day-qty').each(function(){n+=Number(this.value||0)});$('#valquantitymenu').val(n);return n}
 function billing(){const q=total(),days=Number($('.plan-days:checked').val()),o=$('#idprogram option:selected');if(!o.val()||manual)return;let u=Number(o.data('unitprice')||0);if(days===35)u=Number(o.data('thirtyprice')||0)/35;else if(days===22)u=Number(o.data('twentyprice')||0)/22;else if(days===11)u=Number(o.data('tenprice')||0)/11;else if(days===5)u=Number(o.data('fiveprice')||0)/5;$('#valunitprice').val(u.toFixed(2));$('#valtotalprice').val((u*q).toFixed(2))}
 function ids(){return{customer:$('input[name=idcustomer]').val()||$('#idcustomer').val(),program:$('input[name=idprogram]').val()||$('#idprogram').val()}}
 function conflict(){const x=ids(),s=$('#inputdatestart').val(),n=$('.plan-days:checked').val();if(!x.customer||!x.program||!s||!n)return;$.get('{{ route('period.check-conflict') }}',{idcustomer:x.customer,idprogram:x.program,startdate:s,numberofdays:n}).done(d=>{$('#period-conflict-alert').toggleClass('d-none',!d.conflict).text(d.message||'');$('#period-submit').prop('disabled',d.conflict)})}
 function history(){const id=ids().customer;if(!id)return;$.get(`{{ url('customer') }}/${id}/period-history`).done(rows=>{$('#customer-history').html(rows.length?'<strong>Historial del cliente</strong><ul class="mb-0">'+rows.map(r=>`<li>${r.programname} / ${r.textcategoryprice}: ${moment(r.start_date).format('DD-MM-YYYY')} a ${moment(r.end_date).format('DD-MM-YYYY')} (${r.status})</li>`).join('')+'</ul>':'<strong>Historial:</strong> Sin períodos anteriores.').removeClass('d-none')})}
 if($('.plan-days:checked').length&&$('#inputdatestart').val())generate();history();
});
</script>
@endsection

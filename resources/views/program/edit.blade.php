@extends('layouts.maintemplate')

@section('title', 'Añadir un nuevo programa')

@section('content')

<form action="/program/{{$program->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-4 mb-4">

        <div class="col-md-4">
            <div class="card p-3 mb-3">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{$program->name}}" required>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="status" value="Inactivo">
                    <input class="form-check-input" type="checkbox" name="status" id="statusprogram" value="Activo" {{$program->status == 'Activo' ? 'checked' : ''}}>
                    <label class="form-check-label" for="statusprogram"> Estado</label>
                </div>
                <div class="mb-3">
                    <a class="btn btn-secondary" href="{{  url('program') }}" role="button">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3 mb-3">
                <div class="table-responsive">
                    <table class="table align-middle table-borderless">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th style="width: 55px;">Color</th>
                                <th style="width: 55px;"></th>
                                <th class="text-center">1 Día</th>
                                <th class="text-center">5 Días</th>
                                <th class="text-center">10 Días</th>
                                <th class="text-center">20 Días</th>
                                <th style="width: 30px;" class="text-center" ><a href="javascript:void(0);" class="btn rounded-circle btn-primary text-light btn-sm btn-sm btnaddprogprice" onclick="add_row()"><i class="bi bi-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody id="listpricespogram">

                            @php
                                $sno = 1;
                            @endphp

                            @foreach ($programprices as $row)
                                <tr>
                                    <td class="sno">
                                        {{$sno}}
                                        <input type="hidden" name="idprogramprice[]" value="{{$row->id}}">
                                    </td>
                                    <td><input type="text" name="textcategoryprice[]" class="form-control" value="{{ $row->textcategoryprice }}" placeholder="Texto..." style="min-width:200px" required></td>
                                    <td><input type="color" name="color[]" class="form-control form-control-color" value="{{$row->color}}"></td>
                                    <td >
                                        <div class="input-group">
                                            <span class="input-group-text">S/</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="oneprice[]" class="form-control text-center" value="{{ $row->oneprice }}" placeholder="00" style="min-width:64px" required>
                                    </td>
                                    <td>
                                        <input type="text" name="fiveprice[]" class="form-control text-center" value="{{ $row->fiveprice }}" placeholder="00" style="min-width:74px" required>
                                    </td>
                                    <td>
                                        <input type="text" name="tenprice[]" class="form-control text-center" value="{{ $row->tenprice }}" placeholder="00" style="min-width:74px" required>
                                    </td>
                                    <td>
                                        <input type="text" name="twentyprice[]" class="form-control text-center" value="{{ $row->twentyprice }}" placeholder="00" style="min-width:84px" required>
                                    </td>

                                    @if ($sno == 1)
                                    <td class="text-center"> <a href="javascript:void(0);" class="btn btn-sm px-1 py-0 text-danger disabled"><i class="bi bi-trash3-fill"></i></a> </td>
                                    @else
                                    <td class="text-center"> <a href="javascript:void(0);" onclick="remove_row(this)" class="btn btn-sm px-1 py-0 text-danger" data-url="{{ route('programs.destroysingleprogramprice', $row->id) }}"><i class="bi bi-trash3-fill"></i></a> </td>
                                    @endif

                                </tr>
                                @php
                                    $sno ++;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@section('customscripts')
<script type="text/javascript">

function add_row(){
    var sno=document.querySelectorAll(".sno").length;
    sno++;
    var tr=document.createElement("tr");

    tr.innerHTML='<td class="sno">'+sno+'<input type="hidden" name="idprogramprice[]" value="new"></td><td><input type="text" name="textcategoryprice[]" class="form-control" placeholder="Texto..." required></td> <td><input type="color" name="color[]" class="form-control form-control-color"></td> <td> <div class="input-group"> <span class="input-group-text">S/</span> </div></td><td> <input type="text" name="oneprice[]" class="form-control text-center" placeholder="00" required> </td><td> <input type="text" name="fiveprice[]" class="form-control text-center" placeholder="00" required> </td><td> <input type="text" name="tenprice[]" class="form-control text-center" placeholder="00" required> </td><td> <input type="text" name="twentyprice[]" class="form-control text-center" placeholder="00" required> </td><td class="text-center"> <a href="javascript:void(0);" onclick="remove_row(this)" class="btn btn-sm px-1 py-0 text-danger" data-url="0"><i class="bi bi-trash3-fill"></i></a> </td>'
    document.getElementById("listpricespogram").appendChild(tr);
}

function remove_row(e){
    var userURL = $(e).data('url');
    var n=document.querySelector("#listpricespogram").querySelectorAll("tr").length;

    if(userURL == '0'){
        if(n>1&&confirm("¿Estas seguro?")==true){
            var ele=e.parentNode.parentNode;
            ele.remove();
            serial_no();
        }
    }else{
        if(confirm("¿Estas seguro?")==true){
            $.get(userURL, function (data) {
                if(data.message == 'success'){
                    window.location.reload();
                }else{
                    alert('Ocurrio un erro, refresque la página');
                }
            });
        }
    }

}

function serial_no(){
    var cls=document.querySelectorAll(".sno");
    for(var i=0;i<cls.length;i++){
        cls[i].innerHTML=i+1;
    }
}

</script>
@endsection
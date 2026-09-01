<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Control de entrega - {{ request('filterbydate', now()->format('d-m-Y')) }}</title>
    <style>
        @page { size: A4 landscape; margin: 8mm; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: DejaVu Sans, sans-serif; color: #202124; font-size: 7.5pt; }
        .page { width: 100%; page-break-after: always; }
        .page:last-child { page-break-after: auto; }
        .header { width: 100%; border-collapse: collapse; margin-bottom: 3mm; }
        .header td { padding: 0; vertical-align: middle; }
        .logo { width: 20mm; height: 20mm; }
        .title { text-align: center; font-size: 15pt; font-weight: bold; text-transform: uppercase; }
        .subtitle { text-align: center; color: #5f6368; font-size: 8pt; margin-top: 1mm; }
        .summary { text-align: right; font-size: 8pt; line-height: 1.5; }
        .summary strong { font-size: 10pt; }
        table.control { width: 100%; border-collapse: collapse; table-layout: fixed; }
        table.control th { padding: 2mm 1.5mm; color: #fff; background: #477a32; border: .25mm solid #315722; font-size: 6.8pt; text-transform: uppercase; }
        table.control td { height: 10.5mm; padding: 1.2mm 1.5mm; border: .25mm solid #aeb4b8; vertical-align: middle; line-height: 1.15; }
        table.control tbody tr:nth-child(even) { background: #f5f8f3; }
        .number { width: 5%; text-align: center; }
        .customer { width: 17%; }
        .delivery { width: 29%; }
        .program { width: 17%; }
        .phone { width: 10%; text-align: center; }
        .quantity { width: 7%; text-align: center; font-size: 10pt; font-weight: bold; }
        .signature { width: 15%; }
        .muted { color: #5f6368; font-size: 6.4pt; margin-top: .5mm; }
        .footer { width: 100%; margin-top: 2.5mm; color: #5f6368; font-size: 6.5pt; }
        .footer td { padding: 0; }
        .page-number { text-align: right; }
        .empty { text-align: center; padding: 25mm 0; color: #5f6368; font-size: 10pt; }
    </style>
</head>
<body>
@php
    $pages = $perioddays->chunk(11);
    $deliveryDate = $perioddays->isNotEmpty()
        ? Carbon\Carbon::parse($perioddays->first()->perioddate)->format('d-m-Y')
        : request('filterbydate', now()->format('d-m-Y'));
@endphp

@forelse ($pages as $page)
    <div class="page">
        <table class="header">
            <tr>
                <td style="width: 22%;"><img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Delimas"></td>
                <td style="width: 56%;">
                    <div class="title">Control diario de entregas</div>
                    <div class="subtitle">Hoja de ruta y constancia de recepción</div>
                </td>
                <td class="summary" style="width: 22%;">
                    Fecha: <strong>{{ $deliveryDate }}</strong><br>
                    Entregas: <strong>{{ $perioddays->count() }}</strong> &nbsp; Menús: <strong>{{ $perioddays->sum('periodquantity') }}</strong>
                </td>
            </tr>
        </table>

        <table class="control">
            <thead>
                <tr>
                    <th class="number">N.º</th>
                    <th class="customer">Cliente / documento</th>
                    <th class="delivery">Dirección de entrega</th>
                    <th class="program">Programa</th>
                    <th class="phone">Teléfono</th>
                    <th class="quantity">Cant.</th>
                    <th class="signature">Firma / observación</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($page as $delivery)
                <tr>
                    <td class="number">{{ ($loop->parent->index * 11) + $loop->iteration }}</td>
                    <td class="customer"><strong>{{ $delivery->customername }}</strong><div class="muted">Doc. {{ $delivery->customerdocument ?: 'No registrado' }}</div></td>
                    <td class="delivery"><strong>{{ $delivery->customeraddress }} - {{ $delivery->customerdistrict }}</strong>@if($delivery->customeraddressreference)<div class="muted">Ref. {{ $delivery->customeraddressreference }}</div>@endif</td>
                    <td class="program"><strong>{{ $delivery->programname }}</strong><div class="muted">{{ $delivery->textcategoryprice }}</div></td>
                    <td class="phone">{{ $delivery->customerphone }}</td>
                    <td class="quantity">{{ $delivery->periodquantity }}</td>
                    <td class="signature"></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="footer">
            <tr>
                <td>Documento interno de control de entregas - Delimas</td>
                <td class="page-number">Página {{ $loop->iteration }} de {{ $pages->count() }}</td>
            </tr>
        </table>
    </div>
@empty
    <div class="empty">No hay entregas para generar el control.</div>
@endforelse
</body>
</html>

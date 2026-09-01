<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Etiquetas de entrega - {{ request('filterbydate', now()->format('d-m-Y')) }}</title>
    <style>
        @page { size: A4 portrait; margin: 8mm; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: DejaVu Sans, sans-serif; color: #202124; font-size: 9pt; }
        .sheet { width: 100%; page-break-after: always; }
        .sheet:last-child { page-break-after: auto; }
        table.labels { width: 100%; border-collapse: collapse; table-layout: fixed; }
        table.labels > tbody > tr > td { width: 50%; height: 44mm; padding: 2mm; vertical-align: top; }
        .label { height: 40mm; border: 0.35mm dashed #9aa0a6; border-radius: 2mm; padding: 2.5mm; overflow: hidden; }
        .header { width: 100%; border-collapse: collapse; margin-bottom: 1mm; }
        .header td { padding: 0; vertical-align: middle; }
        .logo { width: 9mm; height: 9mm; }
        .delivery-title { text-align: right; color: #5f6368; font-size: 6.5pt; text-transform: uppercase; letter-spacing: .3pt; }
        .date { text-align: right; font-weight: bold; font-size: 9pt; }
        .customer { font-size: 9pt; font-weight: bold; text-transform: uppercase; line-height: 1.08; margin-bottom: .5mm; }
        .document { color: #5f6368; font-size: 6.3pt; margin-bottom: .7mm; }
        .address { font-size: 7pt; font-weight: bold; line-height: 1.1; }
        .reference { color: #5f6368; font-size: 6.3pt; line-height: 1.08; margin-top: .4mm; }
        .footer { width: 100%; border-collapse: collapse; margin-top: 1mm; border-top: .25mm solid #dadce0; }
        .footer td { padding-top: .8mm; vertical-align: top; }
        .program { width: 72%; font-size: 6.5pt; line-height: 1.08; }
        .phone { font-size: 6.5pt; margin-top: .3mm; }
        .quantity { width: 28%; text-align: right; font-size: 8pt; }
        .quantity strong { font-size: 13pt; }
        .empty { border: 0; }
    </style>
</head>
<body>
@forelse ($perioddays->chunk(10) as $sheet)
    <div class="sheet">
        <table class="labels">
            <tbody>
            @foreach ($sheet->chunk(2) as $row)
                <tr>
                    @foreach ($row as $delivery)
                        <td>
                            <div class="label">
                                <table class="header">
                                    <tr>
                                        <td><img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Delimas"></td>
                                        <td>
                                            <div class="delivery-title">Entrega programada</div>
                                            <div class="date">{{ Carbon\Carbon::parse($delivery->perioddate)->format('d-m-Y') }}</div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="customer">{{ $delivery->customername }}</div>
                                <div class="document">Documento: {{ $delivery->customerdocument ?: 'No registrado' }}</div>
                                <div class="address">{{ $delivery->customeraddress }} - {{ $delivery->customerdistrict }}</div>
                                @if ($delivery->customeraddressreference)
                                    <div class="reference">Referencia: {{ $delivery->customeraddressreference }}</div>
                                @endif
                                <table class="footer">
                                    <tr>
                                        <td class="program">
                                            <strong>{{ $delivery->programname }}</strong> / {{ $delivery->textcategoryprice }}
                                            <div class="phone">Tel. {{ $delivery->customerphone }}</div>
                                        </td>
                                        <td class="quantity">Cantidad<br><strong>{{ $delivery->periodquantity }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    @endforeach
                    @if ($row->count() === 1)
                        <td><div class="label empty"></div></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@empty
    <div style="text-align:center; margin-top:40mm; color:#5f6368;">No hay entregas para generar etiquetas.</div>
@endforelse
</body>
</html>

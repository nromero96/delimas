<!doctype html>
<html lang="es">

<head>
    <title>LISTA STICKERS PARA {{ Request::get('filterbydate') }} </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

    <style type="text/css">

    @page { margin: 0; }

    body{
        font-family: 'Roboto', sans-serif;
    }

    th, td {
        padding: 10px;
    }

    .dvstick{
        border:1px solid #eee;
        padding-top: 30px;
        padding-left: 30px;
        padding-right: 30px;
        padding-bottom: 30px;
        border-radius: 20px;
    }

    .myframe{

    }

    </style>

</head>

<body>


<div class="myframe">

    <table style="width: 100%" >

            @php

            $n = 1;     
            @endphp

            @foreach ($perioddays as $row)

                @if ($n%2 != 0)
                <tr>
                @endif
                        <td>
                           <div class="dvstick">
                                <span style="text-transform: uppercase;font-weight: bold;"> {{ $row->customername }}</span><br>
                                <span style="text-transform: uppercase;">{{ $row->customerdistrict }}</span><br>
                                <span style="font-size: 10px;" >{{ $row->programname }}<br>{{ $row->textcategoryprice }}</span>
                           </div>
                        </td>

                @if ($n%2 == 0)
                    </tr>
                @endif

                @php
                    $n++
                @endphp
            @endforeach

    </table>


</div>



</body>

</html>

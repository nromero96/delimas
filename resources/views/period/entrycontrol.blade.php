<!doctype html>
<html lang="es">

<head>
    <title>LISTA CONTROL DE ENTREGA PARA {{ Request::get('filterbydate') }} </title>
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
        padding-top: 5px;
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


            @foreach ($perioddays as $row)

                <tr>
                        <td>
                           <div class="dvstick">
                                <p style="text-align:right; margin-bottom:0px; font-size: 10px; ">{{ $row->programname }} <br> {{ $row->textcategoryprice }}</p>
                                <div style="text-transform: uppercase;font-weight: bold;"> {{ $row->customername }}</div>
                                <span style="text-transform: uppercase;">{{ $row->customeraddress}} - {{ $row->customerdistrict }}</span><br>
                                CEL: {{ $row->customerphone }}
                           </div>
                        </td>

                    </tr>

            @endforeach

    </table>


</div>



</body>

</html>

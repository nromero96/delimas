<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delimas</title>

    <style>
        @font-face {
            font-family: 'Omnes-Regular';
            src: url('/fonts/Omnes-Regular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Ballet Harmony';
            src: url('/fonts/Ballet-Harmony.ttf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aleo:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="landing-promo">
    <div class="hmbanner" style="background-image: url('{{ asset('images/landing/bg-gd-dlmas.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <div class="card_mov_logo d-sm-none text-center">
                        <img src="{{ asset('images/landing/logo-delimas-mov.svg') }}" alt="Delimas">
                    </div>
                    <img src="{{ asset('images/landing/img-hd-delimas.png') }}" alt="Delimas" class="img-deli-person d-none d-sm-block">
                </div>
                <div class="col-md-6 text-center pb-5 pb-sm-0 mb-5 mb-sm-0 mt-4 mt-sm-5">
                    <img src="{{ asset('images/landing/texto-saludable-delimas.svg') }}" alt="Landing Promo" class="img-text-saludable">
                    <p class="text-center text-white mt-2 mt-sm-0 mb-5 mb-sm-0">
                        Deja de preocuparte y <b>¡LIBERA TU TIEMPO!</b><br>Nosotros nos ocupamos de brindarte:
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="hmmenucontent" style="background-image: url('{{ asset('images/landing/persona-w1-delimas-73633.svg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center pt-5 pb-5 mt-4 mt-sm-0 order-last order-md-first">
                    <h3 class="tit_acc mt-5 mt-sm-0 pt-5 pt-sm-0">¡Adiós a contar calorías!</h3>
                    <p class="w-75 m-auto mb-2">
                        El secreto para reducir grasa corporal no consiste en contar calorías, sino en crear el hábito de comer más sano.
                    </p>
                    <span class="sub_ecc">El conteo de calorías</span>
                    <span class="sub_adp">es algo del pasado,</span>
                    <p class="w-75 w-sm-50 m-auto">
                        nuestro concepto se enfoca en la calidad de los alimentos que consumimos.
                    </p>
                    <img src="{{ asset('images/landing/tres-menu.png') }}" alt="Delimas" class="menu-img-3">
                </div>
                <div class="col-md-6 text-center order-first order-md-last">
                    <div class="cardmarco">
                        <div class="imagen">
                            <img src="{{ asset('images/landing/bg-marco-334.svg') }}" alt="Landing Promo" class="bg-marco-img">
                        </div>
                        <div class="contenido">
                            <img src="{{ asset('images/landing/icono-63743.svg') }}" alt="Landing Promo" class="img-fluid">
                            <h3>Sabor:</h3>
                            <p class="mb-3 mb-sm-4">
                                Ofrecemos un <b>delicioso menú</b> con la <b>mejor selección de
                                    platos nacionales e internacionales</b> preparados diariamente
por un equipo de cocina con <b>24 años de experiencia</b>.<br>
Somos muy exigentes en la calidad y frescura de los insumos
que empleamos; usamos <b>técnicas de cocción saludables</b>
como horno de convección y plancha; aplicamos <b>controles
    de buenas prácticas de manufactura (BPM)</b>.
                            </p>

                            <img src="{{ asset('images/landing/icono-63252.svg') }}" alt="Landing Promo" class="img-fluid">
                            <h3>Salud:</h3>
                            <p class="mb-3 mb-sm-4">
                                Nuestros planes <b>cumplen</b> con los lineamientos generales de
<b>Alimentación Saludable de los Organismos Mundiales
    de Salud</b>, por eso están indicados para la mayoría de
patologías crónicas como colesterol y triglicéridos
elevados, hígado graso, diabetes, entre otros.
                            </p>

                            <img src="{{ asset('images/landing/icono-63221.svg') }}" alt="Landing Promo" class="img-fluid">
                            <h3>Servicio:</h3>
                            <p>
                                Tienes la opción de <b>personalizar tus comidas de acuerdo
                                    a tus gustos y preferencias</b>. Entregamos todo por
<b>delivery gratuito</b> en 20 distritos de Lima. <br>Delimás es
una marca de Alamesa Service, una empresa con
24 años de experiencia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hmtextinfo pt-1 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h3 class="text-center mt-5 tit_dcb">¡Disfruta cada bocado!</h3>
                    <p class="text-center">
                        Te ofrecemos porciones fáciles de manejar, que puedes elegir de acuerdo a tu preferencia hasta que cumplas tu objetivo, tanto de reducción como de mantenimiento de peso. Disfruta de comer saludable.
                    </p>

                    <a href="javascript:;" class="slc_mnusema">Conoce aquí nuestro menú semanal</a>

                </div>
            </div>
        </div>
    </div>

    <div class="card-menus" id="listcardmenus">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center mt-2">
                        <b>Menú del 1 de febrero al 7 de febrero</b>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="hmformulario" id="hmformulario">
        <div class="container">

            <div class="row">
                <div class="col-md-12 mt-2 mb-1 mt-sm-5 mb-sm-3"><hr></div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center order-last order-md-first">
                    <h4 class="tit_pasos mt-1 mt-sm-4">Pasos para tu compra</h4>
                </div>

                <div class="col-md-9 text-center order-first order-md-last">
                    <h4 class="text-center tit_stp mb-0 mb-sm-5">Solicita tu pedido</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="pasos d-flex justify-content-evenly d-sm-block">
                        <div class="paso paso-1">
                            <span class="num-paso">1</span>
                            <p>Verifica si tu zona
                                está dentro de
                                nuestra cobertura</p>
                            <span class="vertical-line d-none d-sm-inline-block"></span>
                        </div>
                        <div class="paso paso-2">
                            <span class="num-paso">2</span>
                            <p>Selecciona tu producto
                                y servicio</p>
                            <span class="vertical-line d-none d-sm-inline-block"></span>
                        </div>
                        <div class="paso paso-3">
                            <span class="num-paso">3</span>
                            <p>Selecciona tu plan</p>
                            <span class="vertical-line d-none d-sm-inline-block"></span>
                        </div>
                        <div class="paso paso-4">
                            <span class="num-paso">4</span>
                            <p>Medio de pago</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mt-1 mb-2 d-block d-sm-none"><hr style="height: 1.5px;"></div>
                    <form action="{{route('solicitar-pedido')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="address" class="mb-1">Ingresa tu dirección de entrega:</label>
                                <input type="text" class="form-control rounded-pill" name="address" id="address" placeholder="Ejem: Jirón San Lino 1222, Urb. Santa Luisa, Los Olivos" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-3 mb-1 mb-sm-3 col-md-12">
                                <div class="px-2 py-2 rounded" style="background: #fcf4c6;">
                                    <div class="row">
                                        <div class="col-md-4 ps-2 ps-sm-5 text-end">
                                            <img src="{{ asset('images/landing/img-344532.png') }}" alt="Cobertura Delimas" class="cb_imgmoto d-none d-sm-block">

                                            <div class="row pt-2 pb-1 cob_mb-deliv d-sm-none">
                                                <div class="col-4">
                                                   <img src="{{ asset('images/landing/moto-delivery.svg') }}" alt="Cobertura de delivery" class="">
                                                </div>
                                                <div class="col-8 text-start">
                                                    <h4>Cobertura de delivery gratuito en Lima</h4>
                                                    <p>Revisa que tu distrito se encuentre en nuestra zona de cobertura.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <img src="{{ asset('images/landing/maps-w1-delimas-73633.png') }}" alt="Cobertura de delivery mapa" class="img-fluid">
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list_district">
                                                <li>Miraflores</li>
                                                <li>San Isidro</li>
                                                <li>Lince</li>
                                                <li>Jesús María</li>
                                                <li>Magdalena</li>
                                                <li>Surco</li>
                                                <li>San Borja</li>
                                                <li>Surquillo</li>
                                                <li>Barranco</li>
                                                <li>Chorrillos</li>
                                                <li>San Miguel</li>
                                                <li>Breña</li>
                                                <li>Pueblo Libre</li>
                                                <li>San Luis</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 mt-0 mb-2 mt-sm-2 mb-sm-3">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3 mb-sm-0">
                                <div class="rounded prod_servcard">
                                    <h4>Almuerzos saludables</h4>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="product" id="almuerzos_saludable1" value="Almuerzos saludables Estándar">
                                        <label class="form-check-label" for="almuerzos_saludable1">Estándar<br>(acepto todos los ingredientes)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="product" id="almuerzos_saludable2" value="Almuerzos saludables Personalizado">
                                        <label class="form-check-label" for="almuerzos_saludable2">Personalizado<br>(deseo retirar ingredientes)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="prod_servcard rounded">
                                    <h4>Dieta saludable</h4>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="product" id="dieta_saludable1" value="Dieta saludable Estándar">
                                        <label class="form-check-label" for="dieta_saludable1">Estándar<br>(acepto todos los ingredientes)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="product" id="dieta_saludable2" value="Dieta saludable Personalizado">
                                        <label class="form-check-label" for="dieta_saludable2">Personalizado<br>(deseo retirar ingredientes)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 mt-1 mb-1 mt-sm-3 mb-sm-3">
                                <hr>
                            </div>
                        </div>
                        <div class="row rwtb_plan">
                            <div class="form-group col-md-5">
                                <img src="{{ asset('images/landing/img-7433.jpg') }}" alt="Landing Promo" class="img-fluid">
                            </div>
                            <div class="form-group col-md-7">
                                <h4 class="mt-2 mt-sm-0">Reducción</h4>
                                <p>Dirigido a personas que desean bajar de peso, realizando 3 comidas principales por día.</p>
                                <table class="table-listdias">
                                    <thead>
                                        <tr>
                                            <th>DÍAS</th>
                                            <th>DES-ALM-CEN</th>
                                            <th>SIN DES. NI SNACK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>
                                                <label for="plan1">S/ 37.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan1" value="37.00">
                                            </td>
                                            <td>
                                                <label for="plan2">S/ 30.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan2" value="30.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>
                                                <label for="plan3">S/ 74.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan3" value="74.00">
                                            </td>
                                            <td>
                                                <label for="plan4">S/ 60.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan4" value="60.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">10 (+ 1 día gratis)</td>
                                            <td>
                                                <label for="plan5">S/ 148.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan5" value="148.00">
                                            </td>
                                            <td>
                                                <label for="plan6">S/ 120.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan6" value="120.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">20 (+ 2 días gratis)</td>
                                            <td>
                                                <label for="plan7">S/ 222.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan7" value="222.00">
                                            </td>
                                            <td>
                                                <label for="plan8">S/ 180.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan8" value="180.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">30 (+ 3 días gratis)</td>
                                            <td>
                                                <label for="plan9">S/ 296.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan9" value="296.00">
                                            </td>
                                            <td>
                                                <label for="plan10">S/ 240.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan10" value="240.00">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4 mt-sm-5 rwtb_plan">
                            <div class="form-group col-md-5">
                                <img src="{{ asset('images/landing/img-7434.jpg') }}" alt="Landing Promo" class="img-fluid">
                            </div>
                            <div class="form-group col-md-7">
                                <h4 class="mt-2 mt-sm-0">Mentenimiento</h4>
                                <p>Dirigido a personas que desean mantener su peso o que realizan actividad física</p>
                                <table class="table-listdias">
                                    <thead>
                                        <tr>
                                            <th>DÍAS</th>
                                            <th>DES-ALM-CEN</th>
                                            <th>SIN DES. NI SNACK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>
                                                <label for="plan11">S/ 37.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan11" value="37.00">
                                            </td>
                                            <td>
                                                <label for="plan12">S/ 30.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan12" value="30.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>
                                                <label for="plan13">S/ 74.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan13" value="74.00">
                                            </td>
                                            <td>
                                                <label for="plan14">S/ 60.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan14" value="60.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">10 (+ 1 día gratis)</td>
                                            <td>
                                                <label for="plan15">S/ 148.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan15" value="148.00">
                                            </td>
                                            <td>
                                                <label for="plan16">S/ 120.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan16" value="120.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">20 (+ 2 días gratis)</td>
                                            <td>
                                                <label for="plan17">S/ 222.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan17" value="222.00">
                                            </td>
                                            <td>
                                                <label for="plan18">S/ 180.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan18" value="180.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">30 (+ 3 días gratis)</td>
                                            <td>
                                                <label for="plan19">S/ 296.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan19" value="296.00">
                                            </td>
                                            <td>
                                                <label for="plan20">S/ 240.00 </label>
                                                <input type="radio" name="plan" class="form-check-input" id="plan20" value="240.00">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 mt-1 mb-1 mt-sm-3 mb-sm-3">
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="form-group col-md-12">
                                <p class="text-center text-sm-start">La programación de pedidos se realiza con un día de anticipación, de lunes a viernes de 10 am a 3 pm; si el pedido llega fuera de ese horario, se programa el
                                    siguiente día útil y la entrega el subsiguiente día.</p>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <input type="text" class="form-control rounded-pill" name="name" placeholder="Nombres y apellidos:" required>
                            </div>
                            <div class="form-group mb-2 mb-sm-3 col-md-6">
                                <input type="text" class="form-control rounded-pill" name="phone" placeholder="Teléfono:" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <b class="d-block d-sm-inline-block align-top me-sm-3 text-center text-sm-star border-bottom mb-1 mb-sm-0 text_pagar">Pagar con:</b>
                                <div class="d-inline align-top me-3 text-end">
                                    <label class="form-check-label payment_yape" for="payment_yape"><b>Yape</b><br><span>999 999 999</span></label>
                                    <input class="form-check-input" type="radio" name="payment" id="payment_yape" value="Yape">
                                </div>
                                <div class="d-inline align-top me-3 text-end">
                                    <label class="form-check-label payment_plin" for="payment_plin"><b>Plin</b> <br><span>999 999 999</span></label>
                                    <input class="form-check-input" type="radio" name="payment" id="payment_plin" value="Transferencia">
                                </div>
                                <div class="d-inline align-top text-end">
                                    <label class="form-check-label payment_pos" for="payment_pos"><b>POS físico</b></label>
                                    <input class="form-check-input" type="radio" name="payment" id="payment_pos" value="POS físico">
                                </div>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <input type="file" class="form-control rounded-pill" name="voucher" placeholder="Adjuntar comprobante de pago">
                            </div>
                            <div class="form-group mb-3 col-md-12 text-end">
                                <button type="submit" class="btn-solicitar mt-2 mt-sm-2 mb-2 mb-sm-4">Solicitar Plan</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="hmfooter" style="background-image: url('{{ asset('images/landing/persona-delimas-73633.svg') }}');">
        <div class="container pt-3 pb-3">
            <div class="row align-items-center">
                <div class="col-4 col-md-5 ftlogo">
                    <img src="{{ asset('images/landing/logo-white-delimas-736784.svg') }}" alt="Landing Promo" class="img-fluid">
                </div>
                <div class="col-8 col-md-7">
                    <div class="row ftcontact">
                        <div class="col-md-3 datosinfo text-end text-sm-center">
                            <span>945-147-262</span>
                            <img src="{{ asset('images/landing/icono-whatsapp-ft-3234.svg') }}" alt="Landing Promo" class="img-fluid">
                        </div>
                        <div class="col-md-4 datosinfo text-end text-sm-center">
                            <span>sacd@delimas.pe</span>
                            <img src="{{ asset('images/landing/icono-mail-ft-3244.svg') }}" alt="Landing Promo" class="img-fluid">
                        </div>
                        <div class="col-md-5 datosinfo text-end text-sm-center">
                            <span>Jr. Progreso Nº 45 – Barranco</span>
                            <img src="{{ asset('images/landing/icono-map-ft.svg') }}" alt="Landing Promo" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="https://wa.me/51999999999" class="float-whatsapp" target="_blank">
        <span>¿Tienes dudas?</span>
        <img src="{{ asset('images/landing/icono-whatsapp-35223.svg') }}" alt="Landing Promo" >
    </a>


    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="successModalLabel">Pedido creado correctamente</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('images/landing/icono-63743.svg') }}" alt="Gracias Delimas" class="img-gracias-modal">
                Pedido creado correctamente.<br> Nos pondremos en contacto contigo en breve.
            </div>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    @if(session('success'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          var successModal = new bootstrap.Modal(document.getElementById('successModal'));
          successModal.show();
        });
      </script>
    @endif

    <script>
        window.addEventListener('scroll', function() {
        const floatBtn = document.querySelector('.float-whatsapp');
        const footer = document.querySelector('.hmfooter');

        // Distancia entre el final del botón y el top del viewport
        const btnBottomPosition = floatBtn.getBoundingClientRect().bottom;

        // Distancia entre el footer y el top del viewport
        const footerTopPosition = footer.getBoundingClientRect().top;

        console.log(floatBtn.getBoundingClientRect().bottom);

        if (footerTopPosition <= btnBottomPosition) {
            // Si el footer está alcanzado, posicionar el botón justo encima del footer
            floatBtn.style.bottom = '23%';

        } else {
            // Si el footer no ha sido alcanzado, mantener el botón en su posición original
            floatBtn.style.bottom = '5%';
        }
    });
    </script>


</body>
</html>

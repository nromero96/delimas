<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planrequest;
use Illuminate\Support\Facades\Http;

class PlanrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valida los campos del formulario
        $request->validate([
            'address' => 'required',
            'product' => 'required',
            'plan' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'payment' => 'required',
            'voucher' => 'required',
        ]);

        //crea un nuevo pedido
        $planrequest = new Planrequest;
        $planrequest->address = $request->address;
        $planrequest->product = $request->product;
        $planrequest->plan = $request->plan;
        $planrequest->name = $request->name;
        $planrequest->phone = $request->phone;
        $planrequest->payment = $request->payment;
        $planrequest->voucher = $request->voucher;
        $planrequest->status = 'Pendiente';
        $planrequest->save();

        // Enviar notificación por WhatsApp al administrador
        $this->sendWhatsAppNotification($planrequest);

        //devuelve a la vista anterior con un mensaje success
        return back()->with('success', 'Pedido creado correctamente. Nos pondremos en contacto contigo en breve.');
    }

    private function sendWhatsAppNotification($planrequest)
    {
        $url = config('services.whatsapp.api_url');
        $token = config('services.whatsapp.access_token');
        $adminPhone = config('services.whatsapp.admin_phone');
    
        $payload = [
            "messaging_product" => "whatsapp",
            "to" => $adminPhone,
            "type" => "template",
            "template" => [
                "name" => "nuevo_pedido", // 🔹 Reemplaza con el nombre real de tu plantilla
                "language" => ["code" => "es"], // 🔹 Idioma de la plantilla
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => $planrequest->name],   // Cliente
                            ["type" => "text", "text" => $planrequest->phone],  // Teléfono
                            ["type" => "text", "text" => $planrequest->product],// Producto
                            ["type" => "text", "text" => $planrequest->plan],   // Plan
                            ["type" => "text", "text" => $planrequest->address],// Dirección
                            ["type" => "text", "text" => $planrequest->payment] // Método de pago
                        ]
                    ]
                ]
            ]
        ];
    
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);
    
        return $response->json();
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

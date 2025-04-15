<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planrequest;
use Illuminate\Support\Facades\Http;
use App\Mail\LibroDeReclamaciones;
use Illuminate\Support\Facades\Mail;

//Log
use Illuminate\Support\Facades\Log;

class PlanrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->get('filterbyid');
        $name = $request->get('filterbyname');
        $phone = $request->get('filterbyphone');
        
        $planrequests = Planrequest::where('id', 'LIKE', "%$id%")
            ->where('name', 'LIKE', "%$name%")
            ->where('phone', 'LIKE', "%$phone%")
            ->orderBy('id', 'DESC')
            ->paginate(20);


        return view('landing-promo/list-request', compact('planrequests'));
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

        Log::info('Datos del formulario: ' . json_encode($request->all()));

        // Validación de los campos del formulario
        $request->validate([
            'address' => 'required',
            'district' => 'required',
            'product' => 'required',
            'plan' => 'required',
            'name' => 'required',
            'phone' => 'required', // Asegurar que sea un número
            'document' => 'required',
            'payment' => 'required',
            'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf', // Voucher opcional
        ]);

        // Manejo del archivo de voucher (si se sube)
        $voucherName = null;
        
        if ($request->hasFile('voucher')) {
            $voucherFile = $request->file('voucher');
            $voucherName = time() . '_' . $voucherFile->getClientOriginalName(); // Agrega timestamp al nombre
            $voucherFile->storeAs('public/vouchers', $voucherName);
        } else {
            Log::error('No se detectó el archivo.');
        }

        // Crea y guarda el nuevo pedido
        $planrequest = new Planrequest();
        $planrequest->fill($request->only(['address', 'district', 'product', 'plan', 'name', 'phone', 'document', 'payment']));
        $planrequest->voucher = $voucherName; // Guarda file en la BD
        $planrequest->status = 'Pendiente';
        $planrequest->save();

        // Enviar notificación por WhatsApp
        $this->sendWhatsAppNotification($planrequest);

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
                            ["type" => "text", "text" => $planrequest->id],    // ID del pedido
                            ["type" => "text", "text" => $planrequest->name],   // Cliente
                            ["type" => "text", "text" => $planrequest->phone],  // Teléfono
                            ["type" => "text", "text" => $planrequest->product],// Producto
                            ["type" => "text", "text" => $planrequest->plan],   // Plan
                            ["type" => "text", "text" => $planrequest->address],// Dirección
                            ["type" => "text", "text" => $planrequest->district],// Distrito
                            ["type" => "text", "text" => $planrequest->document],// DNI
                            ["type" => "text", "text" => $planrequest->payment] // Método de pago
                        ]
                    ]
                ]
            ]
        ];
    
        try {
            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);
    
            if (!$response->successful()) {
                Log::error('Error al enviar notificación WhatsApp', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload
                ]);
            }
    
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Excepción al enviar notificación WhatsApp', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload
            ]);
            return null;
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //select * from planrequests where id = $id
        $planrequest = Planrequest::find($id);
        return view('landing-promo/show-request', compact('planrequest'));
    }

    public function updateStatus(Request $request, $id)
    {
        $planrequest = Planrequest::find($id);
        $planrequest->status = $request->status;
        $planrequest->save();

        return redirect()->route('listrequest')->with('success', 'Estado actualizado correctamente de la solicitud #' . $id);
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


    public function sendReclamo(Request $request)
    {
        // Validación de los campos del formulario
        $request->validate([
            'name' => 'required',
            'dni' => 'required',
            'email' => 'required|email', // Asegurar que sea un correo electrónico válido
            'phone' => 'required', // Asegurar que sea un número
            'date' => 'required|date', // Asegurar que sea una fecha válida
            'description' => 'required',
            'solution' => 'required',
        ]);

        // Enviar reclamo por correo electrónico
        $data = [
            'name' => $request->name,
            'dni' => $request->dni,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'description' => $request->description,
            'solution' => $request->solution,
        ];
 
        
        try {
            Mail::to($request->email) 
                ->bcc(config('services.mail.reclamos_email'))  
                ->send(new LibroDeReclamaciones($data));
            Log::info('Correo enviado a: ' . $request->email);
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al enviar el reclamo. Por favor, inténtalo de nuevo más tarde.');
        }


        return back()->with('success', 'Reclamo enviado correctamente. Nos pondremos en contacto contigo en breve.');
    }

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LibroDeReclamaciones extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reclamo)
    {
        $this->reclamo = $reclamo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('services.mail.from_address'), config('services.mail.from_name'))
            ->subject('Nuevo reclamo recibido')
            ->view('emails.libro_de_reclamaciones')
            ->with([
                'reclamo' => $this->reclamo,
            ]);
    }
}

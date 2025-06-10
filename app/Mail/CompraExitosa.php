<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompraExitosa extends Mailable
{
    use Queueable, SerializesModels;
    public $pieza;
    public $pdf;

    public function __construct($pieza, $pdf)
    {
        $this->pieza = $pieza;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->view('emails.compra')
            ->subject('¡Gracias por tu compra!')
            ->attachData($this->pdf->output(), 'factura.pdf');
    }
}
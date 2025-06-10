<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pieza;
use App\Models\User;

class VentaRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $pieza;
    public $comprador;

    public function __construct(Pieza $pieza, User $comprador)
    {
        $this->pieza = $pieza;
        $this->comprador = $comprador;
    }

    public function build()
    {
        return $this->subject('¡Has vendido una pieza en nuestra plataforma!')
                    ->view('emails.venta_realizada')
                    ->with([
                        'pieza' => $this->pieza,
                        'comprador' => $this->comprador,
                    ]);
    }
}
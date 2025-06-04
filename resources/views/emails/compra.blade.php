@component('mail::message')
    # ¡Gracias por tu compra!

    Has adquirido la pieza: {{ $pieza->titulo }}
    Precio: €{{ $pieza->precio }}

    Adjuntamos tu factura en PDF.

    Gracias por confiar en RetroMotor.
@endcomponent

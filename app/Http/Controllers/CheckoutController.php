<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Pieza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompraExitosa;
use App\Mail\VentaRealizada;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $pieza = Pieza::findOrFail($request->pieza_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $pieza->titulo,
                        'images' => [$pieza->foto ? asset('storage/' . $pieza->foto) : asset('images/default-product.png')],
                    ],
                    'unit_amount' => $pieza->precio * 100, //convertir de centimos a euros
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['pieza' => $pieza->id]),
            'metadata' => [
                'pieza_id' => $pieza->id,
                'user_id' => Auth::id(),
            ],
        ]);

        return redirect()->away($session->url);
    }


public function success(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));
    $session = \Stripe\Checkout\Session::retrieve($request->session_id);

    $piezaId = $session->metadata->pieza_id;
    $pieza = Pieza::with('user')->findOrFail($piezaId); // Cargar la relación user
    $user = Auth::user();
    
    // Crear PDF
    $pdf = Pdf::loadView('pdf.factura', [
        'pieza' => $pieza,
        'user' => $user
    ]);
    
    // Enviar correo al comprador
    Mail::to($user->email)->send(new CompraExitosa($pieza, $pdf));
    
    if ($pieza->user) { 
        \Log::info('Enviando correo a vendedor', [
            'vendedor_email' => $pieza->user->email,
            'vendedor_id' => $pieza->user->id
        ]);
        
        try {
            Mail::to($pieza->user->email)->send(new VentaRealizada($pieza, $user));
            \Log::info('Correo a vendedor enviado con éxito');
        } catch (\Exception $e) {
            \Log::error('Error enviando correo a vendedor: ' . $e->getMessage());
        }
    } else {
        \Log::warning('No se encontró vendedor para la pieza', ['pieza_id' => $pieza->id]);
    }
    
    $amount = $session->amount_total / 100;
    return view('checkout.success', compact('amount'));
}


    public function cancel(Request $request)
    {
        //redirigir a la pieza
        $piezaId = $request->input('pieza');
        if ($piezaId && Pieza::find($piezaId)) {
            return redirect()->route('piezas.show', ['pieza' => $piezaId])
                ->with('error', 'El pago fue cancelado.');
        }
        return redirect()->route('piezas.index')
            ->with('error', 'El pago fue cancelado.');
    }
}
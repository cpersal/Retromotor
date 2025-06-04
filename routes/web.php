<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('piezas.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('mi.perfil');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de piezas
    Route::prefix('piezas')->group(function () {
        Route::get('/', [PiezaController::class, 'index'])->name('piezas.index');
        Route::get('/create', [PiezaController::class, 'create'])->name('piezas.create');
        Route::post('/', [PiezaController::class, 'store'])->name('piezas.store');
        Route::get('/{pieza}', [PiezaController::class, 'show'])->name('piezas.show');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::resource('piezas', PiezaController::class)->except(['index', 'show']);
});

// Rutas del perfil
Route::resource('piezas', PiezaController::class)->only(['index', 'show']);
Route::get('/mi-perfil', [PiezaController::class, 'miPerfil'])->name('mi.perfil');
Route::get('/vendedor/{user}', [PiezaController::class, 'showVendedor'])->name('vendedor.show');
require __DIR__ . '/auth.php';

//Rutas del favorito
Route::post('/favoritos/{pieza}', [FavoritoController::class, 'toggle'])
    ->middleware('auth')
    ->name('favoritos.toggle');
Route::get('/favoritos', [FavoritoController::class, 'index'])->middleware('auth')->name('favoritos.index');

// Rutas de pago
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');

// Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');

require __DIR__ . '/auth.php';

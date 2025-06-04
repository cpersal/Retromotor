@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h2 class="mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">¡Pago completado con éxito!</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Hemos recibido tu pago de {{ number_format($amount, 2) }}€.
                        El vendedor será notificado y se pondrá en contacto contigo para coordinar la entrega.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('piezas.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Volver a la tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

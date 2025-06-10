@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Detalle de la Pieza
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2 p-6">
                        @if ($pieza->foto)
                            <div class="relative h-[32rem] overflow-hidden rounded-xl shadow-lg group">
                                <img src="{{ asset('storage/' . $pieza->foto) }}"
                                    class="absolute h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    alt="{{ $pieza->titulo }}">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300">
                                </div>
                            </div>
                        @else
                            <div class="h-[32rem] bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V17a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="md:w-1/2 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $pieza->titulo }}</h1>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $pieza->categoria }}
                                    </span>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $pieza->estado == 'Nuevo'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : ($pieza->estado == 'Usado'
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200') }}">
                                        {{ $pieza->estado }}
                                    </span>
                                </div>
                            </div>

                            @auth
                                @if (auth()->id() === $pieza->user_id)
                                    <div class="flex space-x-2">
                                        <a href="{{ route('piezas.edit', $pieza) }}"
                                            class="inline-flex items-center px-3 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900 dark:text-blue-300 dark:border-blue-600 dark:hover:bg-blue-800 transition duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('piezas.destroy', $pieza) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta pieza?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-900 dark:text-red-300 dark:border-red-600 dark:hover:bg-red-800 transition duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                {{ number_format($pieza->precio, 2) }}€
                            </span>

                            @if ($pieza->created_at)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Publicado {{ $pieza->created_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>

                        <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-500 dark:text-gray-400 mb-3">VENDEDOR</h4>
                            <a href="{{ route('vendedor.show', $pieza->user->id) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg p-2 transition duration-200">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $pieza->user->name }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Miembro desde
                                            {{ $pieza->user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Descripción</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {!! $pieza->descripcion !!}
                            </p>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Especificaciones</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-start mb-3">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <div>
                                            <span class="block text-sm text-gray-500 dark:text-gray-400">Marca</span>
                                            <span
                                                class="text-gray-700 dark:text-gray-300 font-medium">{{ $pieza->marca }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div>
                                            <span class="block text-sm text-gray-500 dark:text-gray-400">Año</span>
                                            <span
                                                class="text-gray-700 dark:text-gray-300 font-medium">{{ $pieza->año }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-start mb-3">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div>
                                            <span class="block text-sm text-gray-500 dark:text-gray-400">Modelo</span>
                                            <span
                                                class="text-gray-700 dark:text-gray-300 font-medium">{{ $pieza->modelo }}</span>
                                        </div>
                                    </div>
                                    @if ($pieza->motor)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2 mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <div>
                                                <span class="block text-sm text-gray-500 dark:text-gray-400">Motor</span>
                                                <span
                                                    class="text-gray-700 dark:text-gray-300 font-medium">{{ $pieza->motor }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @auth
                            @if (auth()->id() === $pieza->user_id)
                                <div
                                    class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-300">Esta es tu
                                            publicación</span>
                                    </div>
                                    <p class="text-sm text-blue-700 dark:text-blue-400">Puedes editarla o eliminarla usando los
                                        botones de arriba.</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <a href="{{ route('chat.show', $pieza->user_id) }}"
                                        class="w-full flex items-center justify-center px-6 py-3 border border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        Contactar al vendedor
                                    </a>
                                    <form action="{{ route('checkout.process') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="pieza_id" value="{{ $pieza->id }}">
                                        <button type="submit"
                                            class="w-full flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            Comprar ahora
                                        </button>
                                    </form>
                                    <button onclick="toggleFavorito({{ $pieza->id }}, this)"
                                        class="w-full flex items-center justify-center px-6 py-3 border {{ auth()->user()->piezasFavoritas()->where('pieza_id', $pieza->id)->exists() ? 'bg-red-50 border-red-300 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/30' : 'bg-gray-50 border-gray-300 text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        {{ auth()->user()->piezasFavoritas()->where('pieza_id', $pieza->id)->exists() ? 'Quitar de favoritos' : 'Añadir a favoritos' }}
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="space-y-4">
                                <a href="{{ route('login') }}"
                                    class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                    Inicia sesión para contactar
                                </a>

                                <a href="{{ route('login') }}"
                                    class="block w-full text-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Inicia sesión para comprar
                                </a>

                                <a href="{{ route('login') }}"
                                    class="block w-full text-center px-6 py-3 bg-gray-100 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    Inicia sesión para guardar favoritos
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleFavorito(piezaId, button) {
            // Deshabilitar botón durante la petición
            const originalHtml = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando...
            `;

            fetch(`/favoritos/${piezaId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Error en la petición');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'added') {
                        updateButtonState(button, true);
                    } else {
                        updateButtonState(button, false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Error al actualizar favoritos');
                    button.innerHTML = originalHtml;
                })
                .finally(() => {
                    button.disabled = false;
                });
        }

        function updateButtonState(button, isFavorito) {
            if (isFavorito) {
                button.classList.remove('bg-gray-50', 'border-gray-300', 'text-gray-600', 'hover:bg-gray-100',
                    'dark:bg-gray-700', 'dark:border-gray-600', 'dark:text-gray-300', 'dark:hover:bg-gray-600');
                button.classList.add('bg-red-50', 'border-red-300', 'text-red-600', 'hover:bg-red-100',
                    'dark:bg-red-900/20', 'dark:border-red-800', 'dark:text-red-400', 'dark:hover:bg-red-900/30');
                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Quitar de favoritos
                `;
            } else {
                button.classList.remove('bg-red-50', 'border-red-300', 'text-red-600', 'hover:bg-red-100',
                    'dark:bg-red-900/20', 'dark:border-red-800', 'dark:text-red-400', 'dark:hover:bg-red-900/30');
                button.classList.add('bg-gray-50', 'border-gray-300', 'text-gray-600', 'hover:bg-gray-100',
                    'dark:bg-gray-700', 'dark:border-gray-600', 'dark:text-gray-300', 'dark:hover:bg-gray-600');
                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Añadir a favoritos
                `;
            }
        }
    </script>
@endpush
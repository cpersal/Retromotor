@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Mis Piezas Favoritas
    </h2>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if ($piezas->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No tienes piezas favoritas aún.
                        <a href="{{ route('piezas.index') }}" class="text-blue-600 hover:text-blue-800">
                            Explora el catálogo
                        </a> para añadir algunas.
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($piezas as $pieza)
                            <div
                                class="flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm h-full">
                                @if ($pieza->miniatura)
                                    <img src="{{ asset('storage/' . $pieza->miniatura) }}" class="object-cover w-full h-48"
                                        alt="{{ $pieza->titulo }}">
                                @else
                                    <div class="flex items-center justify-center w-full h-48 bg-gray-100 text-gray-400">
                                        <i class="text-5xl fas fa-car"></i>
                                    </div>
                                @endif

                                <div class="flex flex-col flex-grow p-4">
                                    <div class="flex items-start justify-between">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $pieza->titulo }}</h4>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-cyan-800 bg-cyan-100 rounded-full">
                                            {{ $pieza->categoria }}
                                        </span>
                                    </div>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $pieza->marca }} | {{ $pieza->modelo }}
                                        @if ($pieza->motor)
                                            | {{ $pieza->motor }}
                                        @endif
                                    </p>

                                    <div class="flex items-center justify-between mt-auto pt-3">
                                        <span class="text-lg font-bold text-blue-600">
                                            {{ number_format($pieza->precio, 2) }}€
                                        </span>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full 
                                        {{ $pieza->estado == 'Nuevo'
                                            ? 'text-green-800 bg-green-100'
                                            : ($pieza->estado == 'Usado'
                                                ? 'text-yellow-800 bg-yellow-100'
                                                : 'text-gray-800 bg-gray-100') }}">
                                            {{ $pieza->estado }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                                        <span class="text-sm text-gray-500">
                                            <i class="mr-1 fas fa-user"></i> {{ $pieza->user->name }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="mr-1 fas fa-calendar-alt"></i> {{ $pieza->año }}
                                        </span>
                                    </div>

                                    <div class="flex mt-4 space-x-2">
                                        <a href="{{ route('piezas.show', $pieza->id) }}"
                                            class="flex-1 text-center px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-300 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <i class="mr-2 fas fa-eye"></i> Ver
                                        </a>
                                        <button onclick="toggleFavorito({{ $pieza->id }}, this)">
                                            <svg class="w-5 h-5 mr-1 text-red-500" fill="currentColor" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $piezas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleFavorito(piezaId, button) {
            fetch(`/favoritos/${piezaId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'removed') {
                        // Si estás en la vista de favoritos, elimina el elemento del DOM
                        if (window.location.pathname === '/favoritos') {
                            button.closest('.grid > div').remove();

                            // Si no quedan más favoritos, muestra un mensaje
                            if (document.querySelectorAll('.grid > div').length === 0) {
                                document.querySelector('.grid').innerHTML = `
                                <div class="p-6 text-center text-gray-500 col-span-full">
                                    No tienes piezas favoritas aún. 
                                    <a href="{{ route('piezas.index') }}" class="text-blue-600 hover:text-blue-800">
                                        Explora el catálogo
                                    </a> para añadir algunas.
                                </div>
                            `;
                            }
                        }
                    }
                });
        }
    </script>
@endpush

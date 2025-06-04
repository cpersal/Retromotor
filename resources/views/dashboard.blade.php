@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Artículos de {{ $vendedor->name }}
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vendedor->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">Miembro desde
                            {{ $vendedor->created_at->format('d M Y') }}</p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $piezas->count() }} artículos en venta</p>
                    </div>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Artículos en venta</h3>

            @if ($piezas->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">Este vendedor no tiene artículos publicados actualmente</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($piezas as $pieza)
                        <div
                            class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('piezas.show', $pieza->id) }}" class="block">
                                @if ($pieza->foto)
                                    <div class="h-48 overflow-hidden">
                                        <img src="{{ asset('storage/' . $pieza->foto) }}"
                                            class="w-full h-full object-cover transition duration-500 hover:scale-105"
                                            alt="{{ $pieza->titulo }}">
                                    </div>
                                @else
                                    <div class="h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V17a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            {{ $pieza->titulo }}</h3>
                                        <span
                                            class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($pieza->precio, 2) }}€</span>
                                    </div>

                                    <div class="flex space-x-2 mb-2">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $pieza->categoria }}
                                        </span>
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $pieza->estado == 'Nuevo'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                : ($pieza->estado == 'Usado'
                                                    ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                    : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200') }}">
                                            {{ $pieza->estado }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ $pieza->descripcion}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $piezas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

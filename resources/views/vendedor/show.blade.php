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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($piezas as $pieza)
                        <div
                            class="flex flex-col overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm h-full">
                            <a href="{{ route('piezas.show', $pieza->id) }}" class="block flex flex-col flex-grow">
                                @if ($pieza->miniatura)
                                    <img src="{{ asset('storage/' . $pieza->miniatura) }}" class="object-cover w-full h-48"
                                        alt="{{ $pieza->titulo }}">
                                @else
                                    <div
                                        class="flex items-center justify-center w-full h-48 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500">
                                        <i class="text-5xl fas fa-car"></i>
                                    </div>
                                @endif

                                <div class="flex flex-col flex-grow p-4">
                                    <div class="flex items-start justify-between">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $pieza->titulo }}
                                        </h4>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-cyan-800 bg-cyan-100 dark:bg-cyan-900 dark:text-cyan-200 rounded-full">
                                            {{ $pieza->categoria }}
                                        </span>
                                    </div>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $pieza->marca }} | {{ $pieza->modelo }}
                                        @if ($pieza->motor)
                                            | {{ $pieza->motor }}
                                        @endif
                                    </p>

                                    <div class="flex items-center justify-between mt-auto pt-3">
                                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                            {{ number_format($pieza->precio, 2) }}€
                                        </span>
                                        <span
                                            class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full 
                                            {{ $pieza->estado == 'Nuevo'
                                                ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200'
                                                : ($pieza->estado == 'Usado'
                                                    ? 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200'
                                                    : 'text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-300') }}">
                                            {{ $pieza->estado }}
                                        </span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="mr-1 fas fa-user"></i> {{ $pieza->user->name }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="mr-1 fas fa-calendar-alt"></i> {{ $pieza->año }}
                                        </span>
                                    </div>
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

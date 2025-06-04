@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Catálogo de Piezas
    </h2>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="p-4 bg-white rounded-lg shadow">
                    <form id="search-form" class="space-y-4">
                        <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4">
                            <div class="flex-1">
                                <div class="relative flex rounded-md shadow-sm">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="block w-full rounded-l-md border-gray-300 pl-4 pr-12 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="Buscar por título, marca o modelo...">
                                    <button type="submit"
                                        class="relative inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <i class="fas fa-search mr-2"></i> Buscar
                                    </button>
                                </div>
                            </div>

                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="filterDropdown">
                                    <i class="fas fa-sliders-h mr-2"></i> Filtros
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 z-10 mt-2 w-72 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="filterDropdown">
                                    <div class="p-4 space-y-4">
                                        <div>
                                            <label for="categoria"
                                                class="block text-sm font-medium text-gray-700">Categoría</label>
                                            <select id="categoria" name="categoria"
                                                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                <option value="">Todas</option>
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria }}"
                                                        {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                                        {{ $categoria }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="marca"
                                                class="block text-sm font-medium text-gray-700">Marca</label>
                                            <select id="marca" name="marca"
                                                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                <option value="">Todas</option>
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca }}"
                                                        {{ request('marca') == $marca ? 'selected' : '' }}>
                                                        {{ $marca }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="estado"
                                                class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select id="estado" name="estado"
                                                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                                <option value="">Todos</option>
                                                @foreach ($estados as $estado)
                                                    <option value="{{ $estado }}"
                                                        {{ request('estado') == $estado ? 'selected' : '' }}>
                                                        {{ $estado }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Rango de precios
                                                (€)</label>
                                            <div class="mt-1 grid grid-cols-2 gap-2">
                                                <input type="number" step="0.01" min="0" name="min_price"
                                                    value="{{ request('min_price') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    placeholder="Mínimo">
                                                <input type="number" step="0.01" min="0" name="max_price"
                                                    value="{{ request('max_price') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    placeholder="Máximo">
                                            </div>
                                        </div>

                                        <div class="flex space-x-2">
                                            <button type="submit"
                                                class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                <i class="fas fa-filter mr-2"></i> Aplicar
                                            </button>
                                            <a href="{{ route('piezas.index') }}"
                                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <i class="fas fa-times mr-2"></i> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if (request()->anyFilled(['search', 'categoria', 'marca', 'estado', 'min_price', 'max_price']))
                        <div class="mt-4 flex flex-wrap gap-2">
                            @if (request('search'))
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                                    Búsqueda: "{{ request('search') }}"
                                    <a href="{{ route('piezas.index', array_merge(request()->except('search'), ['page' => 1])) }}"
                                        class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Resultados</h3>
                        <p class="text-sm text-gray-500">
                            Mostrando {{ $piezas->firstItem() }} - {{ $piezas->lastItem() }} de {{ $piezas->total() }}
                            piezas
                        </p>
                    </div>
                </div>

                @if ($piezas->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No se encontraron piezas con los filtros seleccionados.
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

                                    <a href="{{ route('piezas.show', $pieza->id) }}"
                                        class="block w-full mt-4 text-center px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-blue-300 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <i class="mr-2 fas fa-eye"></i> Ver detalles
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $piezas->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection



{{-- cambiar alpine por vue --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams(formData).toString();
            window.location.href = "{{ route('piezas.index') }}?" + params;
        });
    </script>
@endsection

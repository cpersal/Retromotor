@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Editar Pieza: {{ $pieza->titulo }}
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('piezas.update', $pieza) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Foto actual
                                    </label>
                                    @if ($pieza->foto)
                                        <div class="relative h-64 overflow-hidden rounded-lg">
                                            <img src="{{ asset('storage/' . $pieza->foto) }}"
                                                class="w-full h-full object-cover"
                                                alt="Foto actual de {{ $pieza->titulo }}">
                                        </div>
                                    @else
                                        <div
                                            class="h-64 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400 dark:text-gray-500">Sin imagen</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-6">
                                    <label for="foto"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Cambiar foto (Opcional)
                                    </label>
                                    <input type="file" id="foto" name="foto"
                                        class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100
                                                  dark:file:bg-gray-700 dark:file:text-blue-300
                                                  dark:hover:file:bg-gray-600">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Máximo 8MB. Formatos: JPG, PNG, etc.
                                    </p>
                                    @error('foto')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <div class="mb-6">
                                    <label for="titulo"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Título *
                                    </label>
                                    <input type="text" id="titulo" name="titulo"
                                        value="{{ old('titulo', $pieza->titulo) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('titulo')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="categoria"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Categoría *
                                    </label>
                                    <select id="categoria" name="categoria"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                               focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                               dark:bg-gray-700 dark:text-white"
                                        required>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria }}"
                                                {{ old('categoria', $pieza->categoria) == $categoria ? 'selected' : '' }}>
                                                {{ $categoria }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="marca"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Marca *
                                    </label>
                                    <input type="text" id="marca" name="marca"
                                        value="{{ old('marca', $pieza->marca) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('marca')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="modelo"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Modelo *
                                    </label>
                                    <input type="text" id="modelo" name="modelo"
                                        value="{{ old('modelo', $pieza->modelo) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('modelo')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="año"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Año *
                                    </label>
                                    <input type="number" id="año" name="año"
                                        value="{{ old('año', $pieza->año) }}" min="1900" max="{{ date('Y') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('año')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="estado"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Estado *
                                    </label>
                                    <select id="estado" name="estado"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                   dark:bg-gray-700 dark:text-white"
                                        required>
                                        <option value="Nuevo"
                                            {{ old('estado', $pieza->estado) == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                        <option value="Usado"
                                            {{ old('estado', $pieza->estado) == 'Usado' ? 'selected' : '' }}>Usado</option>
                                        <option value="Reconstruido"
                                            {{ old('estado', $pieza->estado) == 'Reconstruido' ? 'selected' : '' }}>
                                            Reconstruido</option>
                                    </select>
                                    @error('estado')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="motor"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Motor (Opcional)
                                    </label>
                                    <input type="text" id="motor" name="motor"
                                        value="{{ old('motor', $pieza->motor) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white">
                                    @error('motor')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="precio"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Precio (€) *
                                    </label>
                                    <input type="number" id="precio" name="precio"
                                        value="{{ old('precio', $pieza->precio) }}" step="0.01" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                  dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('precio')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-8">
                            <label for="descripcion"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Descripción *
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
           focus:outline-none focus:ring-blue-500 focus:border-blue-500
           dark:bg-gray-700 dark:text-white"
                                required>{{ old('descripcion', $pieza->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
                            <script>
                                ClassicEditor
                                    .create(document.querySelector('#descripcion'), {
                                        toolbar: [
                                            'heading',
                                            '|',
                                            'bold',
                                            'italic',
                                            'bulletedList',
                                            'numberedList',
                                            'blockQuote',
                                            '|',
                                            'undo',
                                            'redo'
                                        ]
                                    })
                                    .then(editor => {
                                        document.querySelector('form')?.addEventListener('submit', () => {
                                            editor.updateSourceElement();
                                        });
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });
                            </script>
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('piezas.show', $pieza) }}"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                      text-sm font-medium text-gray-700 dark:text-gray-300
                                      hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 
                                      focus:ring-offset-2 focus:ring-blue-500">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm 
                                           text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Guardar cambios
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

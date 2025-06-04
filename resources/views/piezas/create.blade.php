@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Subir nueva pieza
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div
                    class="p-6 text-gray-900 bg-white border-b border-gray-200 dark:text-gray-100 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('piezas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="titulo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título*</label>
                                <input type="text" id="titulo" name="titulo" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="categoria"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría*</label>
                                <select id="categoria" name="categoria" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="Amortiguador">Amortiguador</option>
                                    <option value="Frenos">Frenos</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Electricidad">Electricidad</option>
                                    <option value="Escape">Escape</option>
                                    <option value="Interior">Interior</option>
                                    <option value="Refrigeracion">Refrigeracion</option>
                                    <option value="Suspensión">Suspensión</option>
                                    <option value="Transmisión">Transmisión</option>

                                </select>
                            </div>

                            <div>
                                <label for="marca"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca*</label>
                                <input type="text" id="marca" name="marca" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="modelo"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modelo*</label>
                                <input type="text" id="modelo" name="modelo" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="año"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Año*</label>
                                <input type="number" id="año" name="año" min="1900" max="{{ date('Y') }}"
                                    required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="estado"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado*</label>
                                <select id="estado" name="estado" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Usado">Usado</option>
                                    <option value="Reconstruido">Reconstruido</option>
                                </select>
                            </div>
                            <div>
                                <label for="precio"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio (€)*</label>
                                <input type="number" step="0.01" id="precio" name="precio" min="0" required
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label for="foto"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                                <input type="file" id="foto" name="foto" accept="image/*"
                                    class="block w-full mt-1 text-sm text-gray-700 dark:text-gray-300
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                    dark:file:bg-blue-800 dark:file:text-blue-100 dark:hover:file:bg-blue-700">
                            </div>
                            <div class="md:col-span-2">
                                <label for="descripcion"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción*</label>
                                <textarea id="descripcion" name="descripcion" rows="3"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="motor"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motor
                                    (opcional)</label>
                                <input type="text" id="motor" name="motor"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    Subir pieza
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                    window.descripcionEditor = editor;

                    const form = document.querySelector('form');
                    form.addEventListener('submit', (e) => {
                        const data = descripcionEditor.getData().trim();

                        if (!data) {
                            e.preventDefault();
                            alert('Por favor, ingresa una descripción.');
                            return false;
                        }

                        document.querySelector('#descripcion').value = data;
                    });
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Nuevo Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf

                        <div class="mt-4">
                            <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                            <input id="nombre" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="categoria" class="block font-medium text-sm text-gray-700">Categoría</label>
                            <select id="categoria" name="categoria" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="Plato de fondo">Plato de Fondo</option>
                                <option value="bebida">Bebida</option>
                                <option value="postre">Postre</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="precio" class="block font-medium text-sm text-gray-700">Precio</label>
                            <input id="precio" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" type="number" step="0.01" name="precio" value="{{ old('precio') }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="disponibilidad" class="block font-medium text-sm text-gray-700">Disponibilidad</label>
                            <select id="disponibilidad" name="disponibilidad" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="1">Disponible</option>
                                <option value="0">No disponible</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-500 disabled:opacity-25 transition">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

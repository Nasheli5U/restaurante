<!-- resources/views/items/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Ítems') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b dark:border-gray-700">Nombre</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700">Descripción</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700">Categoría</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700">Precio</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700">Disponibilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $item->nombre }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $item->descripcion }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $item->categoria }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $item->precio }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">{{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

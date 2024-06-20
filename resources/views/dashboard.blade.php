<!-- resources/views/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Aquí puedes agregar contenido adicional para el dashboard -->
                <!-- Por ejemplo, un mensaje de bienvenida o resumen -->
                <p>Bienvenido, {{ Auth::user()->name }}.</p>
            </div>
        </div>
    </div>
</x-app-layout>

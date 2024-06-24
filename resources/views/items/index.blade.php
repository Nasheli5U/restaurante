<!-- resources/views/items/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Ítems') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="min-w-full bg-gray dark:bg-white-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b dark:border-gray-700 text-white">Nombre</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700 text-white">Descripción</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700 text-white">Categoría</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700 text-white">Precio</th>
                            <th class="py-2 px-4 border-b dark:border-gray-700 text-white">Disponibilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-white">{{ $item->nombre }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-white">{{ $item->descripcion }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-white">{{ $item->categoria }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-white">{{ $item->precio }}</td>
                                <td class="py-2 px-4 border-b dark:border-gray-700 text-white">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="{{ $item->id }}" class="sr-only peer" {{ $item->disponibilidad ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</span>
                                    </label>
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    

</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const itemId = this.value;
                const disponibilidad = this.checked;

                fetch(`{{ url('/items') }}/${itemId}/update-disponibilidad`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ disponibilidad: disponibilidad })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.nextElementSibling.nextElementSibling.textContent = disponibilidad ? 'Disponible' : 'No disponible';
                    } else {
                        alert('Error al actualizar la disponibilidad');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
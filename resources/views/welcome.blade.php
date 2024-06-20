<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Modificar items</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Formulario de Búsqueda -->
        <div class="container mx-auto p-4">
            <form class="max-w-md mx-auto my-10">
                <div class="flex relative">
                    <label for="category-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Categoría</label>
                    <button id="dropdown-button" data-dropdown-toggle="dropdown-category" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                        Categorías <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="dropdown-category" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                            @foreach($categories as $category)
                            <li>
                                <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="selectCategory('{{ $category->name }}')">{{ $category->name }}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <input type="text" id="category-search" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar productos">
                    <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10A7 7 0 1 1 10 3a7 7 0 0 1 7 7z"></path>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>

            <h1 class="text-3xl font-bold mb-4">Items</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($items as $item)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->nombre }}</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->descripcion }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Precio: ${{ $item->precio }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Disponibilidad: {{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</p>
                        <input id="checkbox-{{ $item->id }}" type="checkbox" value="{{ $item->id }}" class="item-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
                @endforeach
            </div>
            <button id="create-order-btn" class="mt-4 px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" disabled>Crear Pedido</button>
        </div>
    </div>

    <script>
        function selectCategory(category) {
            document.getElementById('category-search').value = category;
            document.getElementById('dropdown-category').classList.add('hidden');
        }

        document.getElementById('dropdown-button').addEventListener('click', () => {
            document.getElementById('dropdown-category').classList.toggle('hidden');
        });

        const checkboxes = document.querySelectorAll('.item-checkbox');
        const createOrderBtn = document.getElementById('create-order-btn');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                createOrderBtn.disabled = !anyChecked;
            });
        });

        createOrderBtn.addEventListener('click', () => {
            const selectedItems = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => ({ id: checkbox.value, cantidad: 1 })); // La cantidad predeterminada se establece en 1 para simplicidad

            fetch('{{ route("pedidos.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mesa: 1, items: selectedItems }) // El número de mesa predeterminado se establece en 1 para simplicidad
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    window.location.reload(); // Recargar la página para restablecer el formulario
                }
            });
        });
    </script>
</body>
</html>

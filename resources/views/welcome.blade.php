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


        <a href="{{ route('pedidos.index') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Ver pedidos</a>

        <!-- Contenido Principal -->
        <div class="container mx-auto p-4">
            <div class="flex">
                <!-- Lista de Ítems -->
                <div class="w-2/3 p-4">
                    <form method="GET" action="{{ url('/') }}" class="max-w-md mx-auto my-10">
                        <div class="flex relative">
                            <label for="category-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Categoría</label>
                            <button id="dropdown-button" data-dropdown-toggle="dropdown-category" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                                Categorías <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="dropdown-category" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                                    <li><button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="selectCategory('plato_de_fondo')">Plato de Fondo</button></li>
                                    <li><button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="selectCategory('bebida')">Bebida</button></li>
                                    <li><button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="selectCategory('postre')">Postre</button></li>
                                </ul>
                            </div>
                            <input type="text" id="category-search" name="category" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar productos">
                            <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10A7 7 0 1 1 10 3a7 7 0 0 1 7 7z"></path>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </form>

                    <h1 class="text-3xl font-bold mb-4">Items</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($items as $item)
                            @if(request('category') == '' || $item->categoria == request('category'))
                                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <div class="p-5">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->nombre }}</h5>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->descripcion }}</p>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Precio: ${{ $item->precio }}</p>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Disponibilidad: {{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</p>
                                        <input id="checkbox-{{ $item->id }}" type="checkbox" value="{{ $item->id }}" class="item-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Sección de Ítems Seleccionados -->
                <div class="w-1/3 p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Ítems Seleccionados</h5>
                    <div id="selected-items" class="flow-root mt-4">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Los ítems seleccionados se añadirán aquí -->
                        </ul>
                    </div>
                    <div class="flex space-x-2 mt-4">
                        <button id="create-order-btn" class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" disabled>Generar Pedido</button>
                        <button id="clear-selection-btn" class="px-4 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script>
        function selectCategory(category) {
            document.getElementById('category-search').value = category;
            document.getElementById('dropdown-category').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectedItemsList = document.getElementById('selected-items').querySelector('ul');
            const createOrderBtn = document.getElementById('create-order-btn');
            const clearSelectionBtn = document.getElementById('clear-selection-btn');
            let selectedItems = [];

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const itemName = this.closest('div').querySelector('h5').innerText;
                    const itemPrice = this.closest('div').querySelector('p:nth-of-type(3)').innerText;
                    if (this.checked) {
                        selectedItems.push({ id: this.value, nombre: itemName, precio: itemPrice, cantidad: 1 });
                    } else {
                        selectedItems = selectedItems.filter(item => item.id !== this.value);
                    }
                    updateSelectedItemsList();
                    createOrderBtn.disabled = selectedItems.length === 0;
                });
            });

            function updateSelectedItemsList() {
                selectedItemsList.innerHTML = '';
                selectedItems.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'py-3 sm:py-4 flex items-center justify-between';
                    li.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">${item.nombre}</p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">${item.precio}</p>
                        </div>
                        <div class="flex items-center">
                            <button class="quantity-decrease-btn bg-gray-200 text-gray-700 px-2 py-1 rounded">-</button>
                            <span class="mx-2">${item.cantidad}</span>
                            <button class="quantity-increase-btn bg-gray-200 text-gray-700 px-2 py-1 rounded">+</button>
                        </div>
                    `;
                    li.querySelector('.quantity-decrease-btn').addEventListener('click', () => updateQuantity(item.id, -1));
                    li.querySelector('.quantity-increase-btn').addEventListener('click', () => updateQuantity(item.id, 1));
                    selectedItemsList.appendChild(li);
                });
            }

            function updateQuantity(itemId, change) {
                const item = selectedItems.find(item => item.id === itemId);
                if (item) {
                    item.cantidad += change;
                    if (item.cantidad <= 0) {
                        selectedItems = selectedItems.filter(item => item.id !== itemId);
                    }
                    updateSelectedItemsList();
                    createOrderBtn.disabled = selectedItems.length === 0;
                }
            }

            createOrderBtn.addEventListener('click', function() {
                const tableNumber = prompt('Ingrese el número de mesa:');
                if (tableNumber && selectedItems.length > 0) {
                    fetch('{{ route("pedidos.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ mesa: tableNumber, items: selectedItems })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            clearSelection();
                            fetchItems();
                        }
                    });
                } else {
                    alert('Por favor, ingrese un número de mesa válido y seleccione al menos un ítem.');
                }
            });

            clearSelectionBtn.addEventListener('click', clearSelection);

            function clearSelection() {
                selectedItems = [];
                updateSelectedItemsList();
                checkboxes.forEach(checkbox => checkbox.checked = false);
                createOrderBtn.disabled = true;
            }

            function fetchItems() {
                fetch('{{ url("/") }}')
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newItems = doc.querySelector('.grid');
                        const itemsContainer = document.querySelector('.grid');
                        itemsContainer.innerHTML = newItems.innerHTML;
                    });
            }
        });
    </script>

</body>
</html>

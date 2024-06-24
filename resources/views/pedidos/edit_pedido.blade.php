<!-- resources/views/pedidos/edit_pedido.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Editar Pedido #{{ $pedido->id }}</h1>
        <h2 class="text-xl font-semibold mb-2">Items del Pedido</h2>
        <ul>
            @forelse ($pedido->items as $item)
                <li>{{ $item->nombre }} - Cantidad: {{ $item->pivot->cantidad }}
                    <form action="{{ route('pedidos.remove-item', ['pedido' => $pedido->id, 'item' => $item->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Eliminar</button>
                    </form>
                </li>
            @empty
                <li>No hay items en este pedido.</li>
            @endforelse
        </ul>
        <hr class="my-4">
        <h2 class="text-xl font-semibold mb-2">Agregar Items al Pedido</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($itemsDisponibles as $item)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $item->nombre }}</h5>
                        <p class="mb-3 font-normal text-gray-700">Descripción: {{ $item->descripcion }}</p>
                        <p class="mb-3 font-normal text-gray-700">Precio: ${{ $item->precio }}</p>
                        <p class="mb-3 font-normal text-gray-700">Disponibilidad: {{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</p>
                        <form action="{{ route('pedidos.add-item', $pedido->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="number" name="cantidad" value="1" min="1" class="w-16 text-center border rounded">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">
                                Añadir
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="my-4">
            <button type="button" onclick="window.location='{{ route('pedidos.index') }}'" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Volver a Pedidos
            </button>
        </div>
    </div>
</body>
</html>

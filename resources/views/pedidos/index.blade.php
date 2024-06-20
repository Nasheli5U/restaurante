<!-- resources/views/pedidos/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pedidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8">Pedidos</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Mesa</th>
                        <th scope="col" class="px-6 py-3">Items</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $pedido->mesa }}</td>
                        <td class="px-6 py-4">
                            <ul>
                                @foreach ($pedido->items as $item)
                                <li>{{ $item->nombre }} (x{{ $item->pivot->cantidad }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4">${{ $pedido->total }}</td>
                        <td class="px-6 py-4">{{ $pedido->estado }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline">Ver</a>
                            <a href="{{ route('pedidos.edit_pedido', $pedido->id) }}" class="ml-4 text-yellow-600 dark:text-yellow-500 hover:underline">Editar</a>
                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 dark:text-red-500 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

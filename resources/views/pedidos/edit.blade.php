@extends('layouts.app')

@section('content')
    <div class="container mx-auto">

        <h1 class="text-3xl font-bold mb-4">Editar Pedido #{{ $pedido->id }}</h1>
        
        <!-- Mostrar detalles del pedido y formulario para editar -->

        <h2 class="text-xl font-semibold mb-2">Items del Pedido</h2>
        <ul>
            @foreach ($pedido->items as $item)
                <li>{{ $item->nombre }} - Cantidad: {{ $item->pivot->cantidad }}</li>
            @endforeach
        </ul>

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-2">Agregar Items al Pedido</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($itemsDisponibles as $item)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->nombre }}</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->descripcion }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Precio: ${{ $item->precio }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Disponibilidad: {{ $item->disponibilidad ? 'Disponible' : 'No disponible' }}</p>
                        <input id="checkbox-{{ $item->id }}" type="checkbox" name="items[]" value="{{ $item->id }}" class="item-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Aquí puedes incluir los campos adicionales para editar el pedido -->

            <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
        </form>
    </div>
@endsection

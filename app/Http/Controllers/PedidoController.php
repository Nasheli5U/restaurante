<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Item;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Método para mostrar todos los pedidos
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        $items = Item::all();
        return view('pedidos.create', compact('items'));
    }

    // Método para almacenar un nuevo pedido
    // PedidoController.php


    // PedidoController.php

    public function store(Request $request)
    {
        $pedido = Pedido::create([
            'numero_pedido' => rand(1000, 9999),
            'mesa' => $request->input('mesa'),
            'total' => 0
        ]);

        $total = 0;
        foreach ($request->input('items') as $itemData) {
            $item = Item::find($itemData['id']);
            if ($item) {
                $cantidad = $itemData['cantidad']; // Usamos la cantidad recibida del usuario
                $pedido->items()->attach($item, ['cantidad' => $cantidad]);
                $total += $item->precio * $cantidad;
            }
        }

        $pedido->total = $total;
        $pedido->save();

        return response()->json(['message' => 'Pedido creado exitosamente!', 'pedido' => $pedido], 201);
    }


    // Método para mostrar un pedido específico
    public function ver(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    // Método para mostrar el formulario de edición
    public function edit(Pedido $pedido)
    {
        $itemsDisponibles = Item::all();
        return view('pedidos.edit_pedido', compact('pedido', 'itemsDisponibles'));
    }

    // Método para actualizar un pedido existente
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'mesa' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        $pedido->update([
            'mesa' => $request->input('mesa'),
            'estado' => $request->input('estado'),
        ]);

        $pedido->items()->detach();

        $total = 0;
        foreach ($request->input('items', []) as $itemId) {
            $item = Item::find($itemId);
            if ($item) {
                $cantidad = $request->input('cantidades')[$itemId];
                $pedido->items()->attach($item, ['cantidad' => $cantidad]);
                $total += $item->precio * $cantidad;
            }
        }

        $pedido->total = $total;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente!');
    }

    // Método para eliminar un pedido
    public function destroy(Pedido $pedido)
    {
        $pedido->items()->detach();
        $pedido->delete();
        return response()->json(null, 204);
    }

    // Método para mostrar la vista de bienvenida con ítems
    public function showe()
    {
        $items = Item::all();
        return view('welcome', compact('items'));
    }

    // Método para agregar un ítem a un pedido
    public function addItem(Request $request, Pedido $pedido)
{
    $request->validate([
        'item_id' => 'required|exists:items,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $item = Item::find($request->item_id);
    $cantidad = $request->cantidad;

    // Verificar si el ítem ya está en el pedido
    $existingItem = $pedido->items()->where('item_id', $item->id)->first();
    if ($existingItem) {
        // Si el ítem ya existe, actualizar la cantidad
        $newQuantity = $existingItem->pivot->cantidad + $cantidad;
        $pedido->items()->updateExistingPivot($item->id, ['cantidad' => $newQuantity]);
    } else {
        // Si el ítem no existe, adjuntarlo al pedido
        $pedido->items()->attach($item, ['cantidad' => $cantidad]);
    }

    $pedido->total += $item->precio * $cantidad;
    $pedido->save();

    return redirect()->route('pedidos.edit', $pedido)->with('success', 'Ítem agregado exitosamente!');
}


    // Método para remover un ítem de un pedido
    public function removeItem(Pedido $pedido, Item $item)
    {
        $pedido->items()->detach($item);

        // Recalcular el total
        $total = 0;
        foreach ($pedido->items as $pedidoItem) {
            $total += $pedidoItem->precio * $pedidoItem->pivot->cantidad;
        }

        $pedido->total = $total;
        $pedido->save();

        return redirect()->route('pedidos.edit', $pedido)->with('success', 'Ítem eliminado exitosamente!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Item;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function showe()
    {
        $items = Item::all();
        return view('welcome', compact('items'));
    }

    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $pedido = Pedido::create([
            'numero_pedido' => rand(1000, 9999), // Generar un número aleatorio para demostración
            'mesa' => $request->input('mesa'),
            'total' => 0 // Esto se calculará más adelante
        ]);

        $total = 0;
        $items = $request->input('items');
        foreach ($items as $item) {
            $itemModel = Item::find($item['id']);
            $cantidad = $item['cantidad'];
            $pedido->items()->attach($itemModel, ['cantidad' => $cantidad]);
            $total += $itemModel->precio * $cantidad;
        }

        $pedido->total = $total;
        $pedido->save();

        return response()->json(['message' => 'Pedido creado exitosamente!', 'pedido' => $pedido], 201);
    }

    public function edit(Pedido $pedido)
    {
        $itemsDisponibles = Item::all();
        return view('pedidos.edit_pedido', compact('pedido', 'itemsDisponibles'));
    }

    public function update(Request $request, Pedido $pedido)
{
    $request->validate([
        'mesa' => 'required|string|max:255',
        'estado' => 'required|string|max:255',
        // Agrega aquí las validaciones para los otros campos que quieras actualizar
    ]);

    $pedido->update([
        'mesa' => $request->input('mesa'),
        'estado' => $request->input('estado'),
        // Actualiza aquí los otros campos necesarios
    ]);

    // Actualizar los ítems del pedido
    $pedido->items()->detach(); // Eliminar todos los ítems actuales del pedido

    $total = 0;
    foreach ($request->input('items', []) as $itemId) {
        $itemModel = Item::find($itemId);
        if ($itemModel) {
            $cantidad = 1; // Ajusta esto según cómo se maneje la cantidad desde el formulario
            $pedido->items()->attach($itemModel, ['cantidad' => $cantidad]);
            $total += $itemModel->precio * $cantidad;
        }
    }

    $pedido->total = $total;
    $pedido->save();

    return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente!');
}


    public function show(Pedido $pedido)
    {
        return $pedido->load('items');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->items()->detach(); // Desvincular todos los ítems asociados al pedido
        $pedido->delete();
        return response()->json(null, 204);
    }
}

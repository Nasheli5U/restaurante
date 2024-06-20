<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Item;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('welcome', compact('items'));
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
    public function show(Pedido $pedido)
    {
        return $pedido->load('items');
    }

    public function update(Request $request, Pedido $pedido)
    {
        $pedido->update($request->all());
        $pedido->items()->detach();
        $items = $request->input('items');
        foreach ($items as $item) {
            $pedido->items()->attach($item['item_id'], ['cantidad' => $item['cantidad']]);
        }
        $pedido->total = $pedido->items->sum(function($item) {
            return $item->pivot->cantidad * $item->precio;
        });
        $pedido->save();
        return response()->json($pedido->load('items'), 200);
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return response()->json(null, 204);
    }
}

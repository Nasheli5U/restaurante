<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'precio' => 'required|numeric',
            'disponibilidad' => 'required|boolean',
        ]);

        Item::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Item añadido exitosamente.');
    }

    public function index()
    {
        
        $items = Item::all();
        
        return view('items.index', compact('items'));
    }
    public function show(Item $item)
    {
        return $item;
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(null, 204);
    }

    public function updateDisponibilidad($id, Request $request)
    {
        $item = Item::find($id);
        if ($item) {
            $item->disponibilidad = $request->input('disponibilidad');
            $item->save();
            return response()->json(['success' => true, 'message' => 'Disponibilidad actualizada correctamente']);
        }

        return response()->json(['success' => false, 'message' => 'Ítem no encontrado'], 404);
    }

}

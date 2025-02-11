<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all(); // Mengambil semua data order dari database
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'total_price' => 'required|numeric|min:0',
    ]);

    $order = Order::create($validated);
    return response()->json($order, 201);
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'total_price' => 'required|numeric|min:0',
    ]);

    $order = Order::findOrFail($id);
    $order->update($validated);
    return response()->json($order);
}
public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();
    return response()->json(['message' => 'Order deleted successfully']);
}
}
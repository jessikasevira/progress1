<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; // 🛠️ Tambahkan ini agar Customer dikenali

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::with('products')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:customers,username|max:255', // 🛠️ Tambah validasi username
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    public function show($id)
    {
        $customer = Customer::with('products')->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json($customer, 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:customers,username,'.$id.'|max:255', // 🛠️ Tambah username
            'email' => 'sometimes|required|email|unique:customers,email,'.$id,
            'phone' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
        ]);

        $customer->update($validated);
        return response()->json($customer, 200);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
}

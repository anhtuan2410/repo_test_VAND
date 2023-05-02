<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $stores = Store::query();

        if ($search) {
            $stores->where('name', 'LIKE', "$search%");
        }

        $stores = $stores->paginate($perPage);

        return response()->json($stores);
    }

    public function show($id)
    {
        $store = Store::with('user', 'products')->findOrFail($id);

        return response()->json($store);
    }


    public function store(Request $request)
    {
        $data = $request->only('name','user_id');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'user_id' => 'exists:App\Models\User,id',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $store = Store::create($data);

        return response()->json($store, 201);
    }

    public function add_product(Request $request, Store $store)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $store->products()->attach($validatedData['product_id'], ['quantity' => $validatedData['quantity']]);

        return response()->json(['message' => 'Product added to store successfully']);
    }


    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->all());

        return response()->json($store, 200);
    }

    public function destroy($id)
    {
        Store::findOrFail($id)->delete();

        return response()->json('Store deleted successfully', 200);
    }
}

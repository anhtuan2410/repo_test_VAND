<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');
        $products = Product::query();
        if ($search) {
            $products->where('name', 'LIKE', "$search%");
        }
        $products = $products->paginate($perPage);

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with('stores')->find($id);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $data = $request->only('name','price');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'price' => 'required|float'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('name','price');
        $validator = Validator::make($data, [
            'name' => 'string',
            'price' => 'float'
        ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json('Product deleted successfully', 200);
    }

}

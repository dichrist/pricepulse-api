<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::query()->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255','unique:products,slug'],
            'brand' => ['nullable','string','max:255'],
            'sku' => ['nullable','string','max:255'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $product = Product::create($data);

        return response()->json($product, 201);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        return response()->json(Store::query()->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255','unique:stores,slug'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $store = Store::create($data);

        return response()->json($store, 201);
    }
}

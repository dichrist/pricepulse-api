<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\AnalyzePriceEntryJob;
use App\Models\PriceEntry;
use Illuminate\Http\Request;

class PriceEntryController extends Controller
{
    public function index(Request $request)
    {
        $q = PriceEntry::query()->orderByDesc('collected_at');

        if ($request->filled('product_id')) $q->where('product_id', $request->integer('product_id'));
        if ($request->filled('store_id')) $q->where('store_id', $request->integer('store_id'));

        return response()->json($q->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'store_id' => ['required','exists:stores,id'],
            'price_cents' => ['required','integer','min:1'],
            'currency' => ['nullable','string','size:3'],
            'source' => ['nullable','string','max:50'],
            'collected_at' => ['nullable','date'],
        ]);

        $entry = PriceEntry::create([
            ...$data,
            'currency' => $data['currency'] ?? 'BRL',
            'source' => $data['source'] ?? 'manual',
            'collected_at' => $data['collected_at'] ?? now(),
        ]);

        AnalyzePriceEntryJob::dispatch($entry->id);

        return response()->json($entry, 201);
    }
}

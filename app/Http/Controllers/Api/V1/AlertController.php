<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
     public function index(Request $request)
    {
        $q = Alert::query()->orderByDesc('created_at');

        if ($request->filled('product_id')) $q->where('product_id', $request->integer('product_id'));
        if ($request->filled('store_id')) $q->where('store_id', $request->integer('store_id'));
        if ($request->filled('type')) $q->where('type', $request->string('type'));
        if ($request->filled('severity')) $q->where('severity', $request->string('severity'));

        return response()->json($q->paginate(20));
    }
}

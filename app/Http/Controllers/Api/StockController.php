<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::with('item')->get();

        return response()->json([
            'data' => $stock->toArray()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'tipe' => ['required', Rule::in(Stock::getTipe())],
            'keterangan' => 'nullable',
        ])->validate();

        $stock = Stock::create($validator);

        return response()->json([
            'data' => $stock->toArray()
        ], Response::HTTP_CREATED);
    }
}

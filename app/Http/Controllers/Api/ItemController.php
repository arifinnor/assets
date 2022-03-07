<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::get();
        return $this->success($items->toArray());
    }

    public function show(Request $request, Item $item)
    {
        return $this->success($item->toArray());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tipe_aset' => ['required', Rule::in(Item::getTipeAset())],
            'tipe' => ['required', Rule::in(Item::getTipe())],
        ])->validate();

        $item = Item::create($validator);

        return $this->success($item->toArray());
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->all());

        return $this->success($item->toArray());
    }

    public function destroy(Request $request, Item $item)
    {
        $item->delete();
        return $this->success();
    }
}

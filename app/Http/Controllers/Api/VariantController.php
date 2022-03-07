<?php

namespace App\Http\Controllers\Api;

use App\Actions\Variant\AddNewVariant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function store(Request $request, AddNewVariant $action)
    {
        $variant = $action->execute($request->all());

        return $this->success($variant, 201);
    }
}

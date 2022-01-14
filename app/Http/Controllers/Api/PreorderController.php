<?php

namespace App\Http\Controllers\Api;

use App\Actions\Preorder\AddNewPreorder;
use App\Http\Controllers\Controller;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreorderController extends Controller
{
    public function store(Request $request, AddNewPreorder $action)
    {
        $preorder = $action->create($request->all());

        return $this->success($preorder, 201);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n1' => 'required|integer|min:0',
            'n2' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $sum = $request->n1 + $request->n2;
        return ["result" => $sum];
    }

    public function minus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n1' => 'required|integer|min:0',
            'n2' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $minus = $request->n1 - $request->n2;
        return ["result" => $minus];
    }
}

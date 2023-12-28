<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Exception;
use Log;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try {
            $previusUser = User::where('username', $request->username)->first();
            if ($previusUser) {
                return response()->json(
                    ['errors' => ['El mail que desea registrar ya existe, si no recuerda su contraseña, puede recuperarla']],
                    409
                );
            }

            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            return $user;
        } catch (Exception $e) {
            Log::error("REGISTER_ERROR: " . $e->getMessage());
            return response()->json(['errors' => ['register error']], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        try {
            $user = User::where('username', $request->username)->firstOrFail();
            if (Hash::check($request->password, $user->password)) {
                $key = env('JWT_SECRET');
                $payload = ["id" => $user->id];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return ["token" => $jwt, "user" => $user];
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Usuario o contraseña incorrectos']], 404);
        }

        return response()->json(['errors' => ['Usuario o contraseña incorrectos']], 404);
    }
}

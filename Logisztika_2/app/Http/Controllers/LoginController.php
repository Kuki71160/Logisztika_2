<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        $user = User::where('email',$request -> email) -> firstOrFail();

        if (Hash::check($request -> password, $user -> password)) {
            return response() -> json(["success" => true, "user_id" => $user -> id, "role" => $user -> role]);
        }
        else{
            return response() -> json(["success" => false, "message" => "Hibás jelszó"]);
        }

    }
}
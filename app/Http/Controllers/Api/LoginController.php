<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required'
        ]);

        $user = User::where('email', $request->correo)->first();

        if(!$user || !Hash::check($request->contraseña, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'data' => [
                'atributos' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'correo' => $user->email,
                ],
                'token' => $user->createToken($request)->plainTextToken,
            ],
        ], Response::HTTP_OK);

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserAdminRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function store(UserRequest $request)
    {

        $newUser = new User();
        $newUser->name          = $request->name;
        $newUser->email         = $request->email;
        $newUser->type_user_id  = 2; //client
        $newUser->password      = Hash::make($request->password);

        if ($newUser->save()) {
            return response()->json([
                'res' => true,
                'message' => 'Registro exitoso'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Error al registrar'
            ], 400);
        }
    }

    public function storeAdmin(UserAdminRequest $request)
    {
        $newUser = new User();
        $newUser->name          = $request->name;
        $newUser->email         = $request->email;
        $newUser->type_user_id  = $request->type_user_id;
        $newUser->password      = Hash::make($request->password);

        if ($newUser->save()) {
            return response()->json([
                'res' => true,
                'message' => 'Registro exitoso'
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Error al registrar'
            ], 400);
        }
    }

    public function login(LoginRequest $request)
    {
        // Obtenemos al usuario a autenticar
        $user = User::where('email', $request->email)->first();
        // Vemos si las credenciales son erróneas para retornar un mensaje de error
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'res' => true,
                'token' => $user->createToken('Bodytech')->plainTextToken,
                'user' => $user,
                'message' => 'Bienvenido al sistema',
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Email o password incorrecto',
            ], 400);
        }
    }

    public function logout()
    {
        //Obtenemos usuario logeado
        $user = Auth::user();
        //Busca todos los token del usuario en la base de datos y los eliminamos;
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json([
            'res' => true,
            'message' => 'Hasta la proxima',
        ], 200);
    }
}
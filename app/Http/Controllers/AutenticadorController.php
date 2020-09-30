<?php

namespace App\Http\Controllers;

use App\Events\EventNovoRegistro;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AutenticadorController extends Controller
{
    public function registry(Request $request)
    {
        //nome, email, senha
        $request->validate([
           'name' => 'required|string',
           'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
           'name' => $request->name,
           'email' => $request->email,
           'password' => bcrypt($request->password),
           'token' => Str::Random(60)
        ]);

        $user->save();

        event(new eventNovoRegistro($user));

        return response()->json([
           'res' => 'Usuario criado com sucesso'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = [
          'email' => $request->email,
          'password' => $request->password,
          'active' => 1
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
               'res' => 'acesso negado'
            ], 401);
        }
        $user = $request->user();
        $token =  $user->createToken('Token de acesso')->acessToken;

        return response()->json([
           'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
           'res' => 'Deslogado com sucesso'
        ]);
    }

    public function ativarRegistro($id, $token) {
        $user = User::find($id);
        if ($user) {
            if ($user->token == $token){
                $user->active = true;
                $user->token = '';
                $user->save();
                return view('registroativo');
            }
        }
        return view('registroerro');
    }
}

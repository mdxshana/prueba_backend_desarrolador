<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class ApiAuthController extends Controller
{
    /**
     * metodo que permite hacer login a un usuario
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $this->removerTokens($user->id);
            $token = $user->createToken('Laravel Personal Access Client')->accessToken; // crea el token de usuario usando laravel-passport

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'error' => "Estas credenciales no coinciden con nuestros registros"
            ], 400);
        }
    }


    public function logout(){
        if (Auth::check()) {
            $this->removerTokens(Auth::user()->id);
            return response()->json([],200);
        }
    }


    private function removerTokens($user_id){
        Passport::token()->where('user_id', Auth::user()->id)->delete();
    }
}

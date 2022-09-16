<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response([
                "message" => "Usuario y Contraseña es invalido. "
            ]);
        }
        $accessToken = Auth::user()->createToken('authTestToken')->accessToken;
        $u = Auth::user();
        $user = User::with('rol')->find($u->id);
        return response([
            "user" => $user,
//          'rol' => Auth::user()->rol()->get(),
            "access_token" => $accessToken
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
        }
        return response()->json([
            'ok' => true,
            'message' => 'Se cerro session correctamente.',
        ]);

    }

    public function me()
    {
        return response()->json([
            'ok' => true,
            'user' => Auth::user()
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = new User([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol_id' => $request->rol_id ?: '2', //por defecto  se registra  como paciente si no viene un rol_id
        ]);
        Patient::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'ci' => $request->ci,
            'user_id' => $user->id,
        ]);

        $user->save();

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'ok' => true,
            'user' => $user,
            'access_token' => $token
        ]);
    }


}

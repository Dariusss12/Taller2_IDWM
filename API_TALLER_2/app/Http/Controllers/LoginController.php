<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    //
    public function login(Request $request){

        $customMessages = [
            'username.required' => 'Debe completar el campo Nombre de usuario.',
            'password.required' => 'Debe completar el campo Contraseña.',
        ];
        // Validar las credenciales
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], $customMessages);

        // Si la validación falla, retornar los errores
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try{
        // Intentar autenticar al usuario
            if (!$token = JWTAuth::attempt($request->only('username', 'password'))) {
                return response()->json([
                    'error' => ['credentials' => 'Credenciales incorrectas, intentalo denuevo.']
                ], 401);
            }
        }catch (JWTException $e){
            return response()->json([
                'error' => 'Error del servidor'
            ],500);
        }

        // Autenticación exitosa, retornar el token
        return response()->json(compact('token'), 200);
    }

    public function logout()
    {
        try {
            // Invalidar el token actual del usuario
            JWTAuth::invalidate(JWTAuth::parseToken());

            return response()->json([
                'message' => 'Logout exitoso.'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Error del servidor al intentar cerrar sesión.'
            ], 500);
        }
    }
}

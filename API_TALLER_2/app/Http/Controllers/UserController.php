<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Get all users data
     * @return users
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users],200);
    }

    /**
     * Store a new user, checking all fields
     * @param request
     * @return response
     */
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $fields=$request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'id_number' => 'required|unique:users,id_number',
                'email' => 'required|email|unique:users,email',
                'points_earned' => 'required|integer|min:0',
            ],[
                'name.required' => 'El campo Nombres es obligatorio.',
                'lastname.required' => 'El campo Apellidos es obligatorio.',

                'id_number.required' => 'El campo Número de Identificación es obligatorio.',
                'id_number.unique' => 'El Número de Identificación ya existe en el sistema.',

                'email.required' => 'El campo Correo electrónico es obligatorio.',
                'email.email' => 'El campo Correo electrónico debe ser una dirección de correo válida.',
                'email.unique' => 'El correo electrónico ya existe en el sistema.',

                'points_earned.required' => 'El campo Puntos ganados es obligatorio.',
                'points_earned.integer' => 'Los puntos ganados debe ser un número entero.',
                'points_earned.min' => 'Los puntos ganados deben ser numeros enteros positivos.'

            ]);

            $user=User::create([
                'name'=>$fields['name'],
                'lastname'=>$fields['lastname'],
                'id_number'=>$fields['id_number'],
                'email'=>$fields['email'],
                'points_earned'=>$fields['points_earned']
            ]);
            DB::commit();
            return response()->json(['user' => $user],200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }

    /**
     * Update a user data by id.
     * @param request
     * @param user
     * @return response
     */
    public function update(Request $request, User $user){
        try{
            DB::beginTransaction();
            $fields=$request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|regex:/^[^@]+@[^@.]+\.[^@]+$/|unique:users,email,' . $user->id,
                'points_earned' => 'required|integer|min:0',
            ],[
                'name.required' => 'El campo Nombres es obligatorio.',
                'lastname.required' => 'El campo Apellidos es obligatorio.',

                'email.required' => 'El campo Correo electrónico es obligatorio.',
                'email.regex' => 'El campo Correo electrónico debe ser una dirección de correo válida.',
                'email.unique' => 'El correo electrónico ya existe en el sistema.',

                'points_earned.required' => 'El campo Puntos ganados es obligatorio.',
                'points_earned.integer' => 'Los puntos ganados debe ser un número entero.',
                'points_earned.min' => 'Los puntos ganados deben ser numeros enteros positivos.'

            ]);

            $user->update([
                'name'=>$fields['name'],
                'lastname'=>$fields['lastname'],
                'email'=>$fields['email'],
                'points_earned'=>$fields['points_earned']
            ]);
            DB::commit();
            return response()->json(['user' => $user],200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }

    /**
     * Delete a user from database.
     * @param user
     * @return response
     */
    public function destroy(User $user)
    {
        try{
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json('Usuario eliminado correctamente',200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }
}

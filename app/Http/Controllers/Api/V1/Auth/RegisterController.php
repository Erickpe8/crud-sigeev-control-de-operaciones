<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        // return $request; 
        try {
             
            // Crear un nuevo usuario
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->birthdate = $request->birthdate;

            $user->gender_id = $request->gender_id;
            $user->document_type_id = $request->document_type_id;
            $user->user_type_id = $request->user_type_id;
            $user->academic_program_id = $request->academic_program_id ?? null;

            $user->document_number = $request->document_number;
            $user->institution_id = $request->institution_id ?? null;
            $user->company_name = $request->company_name ?? null;
            $user->company_address = $request->company_address ?? null;

            $user->status = $request->status ?? true; // Por defecto activo
            $user->accepted_terms = $request->accepted_terms;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['message' => 'Usuario registrado con éxito', 'user'    => new RegisterResource($user),], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al registrar al usuario: ' . $e->getMessage()], 500);
        }
     }
}

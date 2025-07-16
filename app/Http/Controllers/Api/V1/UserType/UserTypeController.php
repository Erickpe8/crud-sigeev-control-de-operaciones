<?php

namespace App\Http\Controllers\Api\V1\UserType;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserType\IndexUserTypeResource;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index(Request $request)
    {
       try {
           $userTypes = UserType::all();
           return response()->json(['message' => 'Lista de tipos de usuario', 'userTypes' => IndexUserTypeResource::collection($userTypes)], 200);
       } catch (Exception $e) {
           return response()->json(['message' => 'Error al obtener la lista de tipos de usuario: ' . $e->getMessage()], 500);
       }
    }
}

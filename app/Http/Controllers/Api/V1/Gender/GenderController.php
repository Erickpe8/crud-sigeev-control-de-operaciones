<?php

namespace App\Http\Controllers\Api\V1\Gender;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Gender\IndexGenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function index(Request $request)
    {
       try {
           $genders = Gender::all();
           return response()->json(['message' => 'Lista de géneros', 'genders' => IndexGenderResource::collection($genders)], 200);
       } catch (Exception $e) {
           return response()->json(['message' => 'Error al obtener la lista de géneros: ' . $e->getMessage()], 500);
       }
    }
}

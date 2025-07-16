<?php

namespace App\Http\Controllers\Api\V1\Institution;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Institution\IndexInstitutionResource;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        try {
           $institutions = Institution::all();
           return response()->json(['message' => 'Lista de instituciones', 'institutions' => IndexInstitutionResource::collection($institutions)], 200);
       } catch (Exception $e) {
           return response()->json(['message' => 'Error al obtener la lista de instituciones: ' . $e->getMessage()], 500);
       }
    }
}

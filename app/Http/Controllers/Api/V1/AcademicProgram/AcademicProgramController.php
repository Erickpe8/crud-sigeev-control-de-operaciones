<?php

namespace App\Http\Controllers\Api\V1\AcademicProgram;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AcademicProgram\IndexAcademicProgramResource;
use App\Models\AcademicProgram;
use Illuminate\Http\Request;

class AcademicProgramController extends Controller
{
    public function index($institution)
    {
       try {
           $academicPrograms = AcademicProgram::where('institution_id', $institution)->get();
           return response()->json(['message' => 'Lista de programas académicos', 'academicPrograms' => IndexAcademicProgramResource::collection($academicPrograms)], 200);
       } catch (Exception $e) {
           return response()->json(['message' => 'Error al obtener la lista de programas académicos: ' . $e->getMessage()], 500);
       }
    }
}

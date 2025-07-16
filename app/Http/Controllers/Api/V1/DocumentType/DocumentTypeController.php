<?php

namespace App\Http\Controllers\Api\V1\DocumentType;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DocumentType\IndexDocumentTypeResource;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index(Request $request)
    {
       try {
           $documentTypes = DocumentType::all();
           return response()->json(['message' => 'Lista de tipos de documentos', 'documentTypes' => IndexDocumentTypeResource::collection($documentTypes)], 200);
       } catch (Exception $e) {
           return response()->json(['message' => 'Error al obtener la lista de tipos de documentos: ' . $e->getMessage()], 500);
       }
    }
}

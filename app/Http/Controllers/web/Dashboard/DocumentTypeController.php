<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin|superadmin']);
    }

    public function index(Request $request)
    {
        return view('dashboards.document-types.index');
    }

    public function list(Request $request)
    {
        $q = trim((string)$request->get('q',''));
        $query = DocumentType::query()->orderBy('code','asc');

        if ($q !== '') {
            $query->where(function($s) use ($q){
                $s->where('code','like',"%{$q}%")
                    ->orWhere('name','like',"%{$q}%");
            });
        }

        $rows = $query->get(['id','code','name','is_active','created_at']);
        return response()->json(['ok'=>true,'data'=>$rows]);
    }

    public function store(Request $request)
    {
        // Normalización básica: código en mayúsculas y sin espacios al inicio/final
        $request->merge([
            'code' => strtoupper(trim((string)$request->input('code'))),
            'name' => trim((string)$request->input('name')),
        ]);

        $data = $request->validate([
            'code'      => ['required','string','max:120', 'unique:document_types,code'],
            'name'      => ['nullable','string','max:120'],
            'is_active' => ['nullable','boolean'],
        ]);

        $row = DocumentType::create([
            'code'      => $data['code'],
            'name'      => $data['name'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? true),
        ]);

        return response()->json(['ok'=>true,'message'=>'Creado correctamente','data'=>$row]);
    }

    public function update(Request $request, $id)
    {
        $row = DocumentType::findOrFail($id);

        $request->merge([
            'code' => strtoupper(trim((string)$request->input('code', $row->code))),
            'name' => trim((string)$request->input('name', $row->name)),
        ]);

        $data = $request->validate([
            'code'      => ['required','string','max:120', Rule::unique('document_types','code')->ignore($row->id)],
            'name'      => ['nullable','string','max:120'],
            'is_active' => ['nullable','boolean'],
        ]);

        $row->update([
            'code'      => $data['code'],
            'name'      => $data['name'] ?? $row->name,
            'is_active' => (bool)($data['is_active'] ?? $row->is_active),
        ]);

        return response()->json(['ok'=>true,'message'=>'Actualizado correctamente','data'=>$row->fresh()]);
    }

    public function destroy(Request $request, $id)
    {
        $row = DocumentType::findOrFail($id);
        $row->delete();
        return response()->json(['ok'=>true,'message'=>'Eliminado']);
    }
}

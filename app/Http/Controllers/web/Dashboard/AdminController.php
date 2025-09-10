<?php

namespace App\Http\Controllers\web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%"); // incluye teléfono en el buscador
            });
        }

        $users = $query->paginate(50)->withQueryString(); // Mantener ?search en la URL

        $genders          = Gender::all();
        $documentTypes    = DocumentType::all();
        $userTypes        = UserType::all();
        $academicPrograms = AcademicProgram::all();
        $institutions     = Institution::all();

        return view('dashboards.admin.admin', compact(
            'users',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions'
        ));
    }

    public function edit(User $user)
    {
        if ($user->hasRole('superadmin')) {
            abort(403, 'No puedes editar al Super Admin.');
        }

        $genders          = Gender::all();
        $documentTypes    = DocumentType::all();
        $userTypes        = UserType::all();
        $academicPrograms = AcademicProgram::all();
        $institutions     = Institution::all();

        return view('admin.users.edit', compact(
            'user',
            'genders',
            'documentTypes',
            'userTypes',
            'academicPrograms',
            'institutions'
        ));
    }

    public function update(Request $request, User $user)
    {
        if ($user->hasRole('superadmin')) {
            return $request->expectsJson()
                ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                : abort(403, 'No puedes editar al Super Admin.');
        }

        $rules = [
            'first_name'          => 'required|string|max:100',
            'last_name'           => 'required|string|max:100',
            'gender_id'           => 'nullable|exists:genders,id',
            'document_type_id'    => 'nullable|exists:document_types,id',
            'user_type_id'        => 'nullable|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',
            'institution_id'      => 'nullable|exists:institutions,id',
            'document_number'     => 'nullable|string|max:50',
            'company_name'        => 'nullable|string|max:255',
            'company_address'     => 'nullable|string|max:255',
            'birthdate'           => 'nullable|string',
            'status'              => 'nullable|boolean',
            'accepted_terms'      => 'nullable|boolean',

            // Teléfono: dígitos, +, -, espacios, paréntesis (7–25)
            'phone'               => ['nullable','string','max:25','regex:/^[0-9+\-\s()]{7,25}$/'],
        ];

        if ($request->email !== $user->getOriginal('email')) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ];
        } else {
            $rules['email'] = 'required|email';
        }

        $validated = $request->validate($rules);

        try {
            // Normalización de fecha
            if (!empty($validated['birthdate'])) {
                try {
                    $birth = Carbon::createFromFormat('d/m/Y', $validated['birthdate']);
                    $validated['birthdate'] = $birth->format('Y-m-d');
                } catch (\Exception $e) {
                    $validated['birthdate'] = Carbon::parse($validated['birthdate'])->format('Y-m-d');
                }
            } else {
                $validated['birthdate'] = null;
            }

            // Normalización de teléfono: trim y compactar espacios múltiples
            if (array_key_exists('phone', $validated) && $validated['phone'] !== null) {
                $phone = trim($validated['phone']);
                // Reemplaza secuencias de espacios por un solo espacio
                $phone = preg_replace('/\s+/', ' ', $phone);
                $validated['phone'] = $phone;
            }

            // fill() tomará phone si está en $fillable del modelo User.
            $user->fill(collect($validated)->except(['password'])->toArray());

            // Campos opcionales controlados explícitamente (opcional pero claro)
            $user->academic_program_id = $validated['academic_program_id'] ?? null;
            $user->institution_id      = $validated['institution_id'] ?? null;
            $user->document_number     = $validated['document_number'] ?? null;
            $user->company_name        = $validated['company_name'] ?? null;
            $user->company_address     = $validated['company_address'] ?? null;
            $user->status              = $validated['status'] ?? true;
            $user->accepted_terms      = $validated['accepted_terms'] ?? false;

            // Asegurar phone explícitamente (redundante pero seguro)
            if (array_key_exists('phone', $validated)) {
                $user->phone = $validated['phone'];
            }

            $user->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Usuario actualizado correctamente.',
                    'user'    => $user,
                ]);
            }

            return redirect()->route('dashboards.admin')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario', [
                'error'   => $e->getMessage(),
                'user_id' => $user->id ?? null,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Error interno del servidor.',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withErrors(['general' => 'Error al actualizar usuario.']);
        }
    }

    public function destroy(User $user)
    {
        $auth = auth()->user();

        // No auto-eliminarse
        if ($auth && $auth->id === $user->id) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propio usuario.']);
        }

        // Un admin no puede eliminar a un superadmin
        if ($user->hasRole('superadmin')) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'No puedes eliminar al Super Admin.'], 403);
            }
            abort(403, 'No puedes eliminar al Super Admin.');
        }

        try {
            $user->delete();

            if (request()->expectsJson()) {
                return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
            }

            return back()->with('success', 'Usuario eliminado correctamente.');
        } catch (\Throwable $e) {
            \Log::error('Error al eliminar usuario', [
                'user_id' => $user->id,
                'msg'     => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json(['message' => 'No se pudo eliminar el usuario.'], 500);
            }

            return back()->withErrors(['error' => 'No se pudo eliminar el usuario.']);
        }
    }
}

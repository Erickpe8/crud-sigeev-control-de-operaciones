<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\DocumentType;
use App\Models\UserType;
use App\Models\AcademicProgram;
use App\Models\Institution;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class ProfileEditController extends Controller
{
    public function edit(User $user)
    {
        $genders          = Gender::all();
        $documentTypes    = DocumentType::all();
        $userTypes        = UserType::all();
        $roles            = Role::all();
        $academicPrograms = AcademicProgram::all();
        $institutions     = Institution::all();

        return view('auth.profile-edit', compact(
            'user', 'genders', 'documentTypes', 'userTypes', 'roles', 'academicPrograms', 'institutions'
        ));
    }

    public function update(Request $request, User $user)
    {
        try {
            // Superadmin: solo se edita a sí mismo
            if ($user->hasRole('superadmin') && $user->id !== $request->user()->id) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'No puedes editar al Super Admin.'], 403)
                    : abort(403, 'No puedes editar al Super Admin.');
            }

            // Validación
            $validated = $request->validate([
                'first_name'           => 'sometimes|string|max:100',
                'last_name'            => 'sometimes|string|max:100',
                'email'                => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($user->id)],
                'birthdate'            => 'sometimes|date_format:d/m/Y',
                'document_number'      => 'sometimes|nullable|string|max:50',
                'gender_id'            => 'sometimes|nullable|exists:genders,id',
                'document_type_id'     => 'sometimes|nullable|exists:document_types,id',
                'user_type_id'         => 'sometimes|nullable|exists:user_types,id',
                'role'                 => 'sometimes|nullable|exists:roles,name', // NO es columna en users
                'academic_program_id'  => 'sometimes|nullable|exists:academic_programs,id',
                'institution_id'       => 'sometimes|nullable|exists:institutions,id',
                'company_name'         => 'sometimes|nullable|string|max:255',
                'company_address'      => 'sometimes|nullable|string|max:255',
                'phone'                => 'sometimes|nullable|string|max:20',
                'password'             => 'sometimes|string|min:8|confirmed',
                'photo'                => 'sometimes|file|mimes:jpg,jpeg,png,webp|max:2048',
                'remove_photo'         => 'sometimes|boolean', // ← opcional: quitar foto
            ]);

            // Fecha d/m/Y → Y-m-d
            if ($request->filled('birthdate')) {
                $validated['birthdate'] = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');
            }

            // Prepara cambios de foto (si aplica)
            $newRelativePath = null;
            $oldRelativePath = $user->profile_photo; // ej: avatars/user_2.jpg

            if ($request->boolean('remove_photo')) {
                $newRelativePath = null; // se quitará la foto
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                // Procesa imagen (autoOrientation ya puede venir desde config/image.php)
                $image = Image::read($file->getPathname())->cover(300, 300);

                // Puedes forzar un formato único si quieres (descomenta para forzar JPG):
                // $image = $image->toJpeg(85); $forcedExt = 'jpg';

                $ext       = isset($forcedExt) ? $forcedExt : $file->extension();
                $filename  = "user_{$user->id}.{$ext}";
                $dir       = storage_path('app/public/avatars');
                File::ensureDirectoryExists($dir);

                // Guardar físicamente nueva imagen
                $image->save($dir.DIRECTORY_SEPARATOR.$filename);

                $newRelativePath = "avatars/{$filename}";
            }

            // Quitar 'role' del fill (Spatie maneja aparte)
            $roleName = Arr::pull($validated, 'role', null);

            // Whitelist para fill (incluye profile_photo)
            $allowed = [
                'first_name','last_name','email','phone','birthdate',
                'gender_id','document_type_id','document_number',
                'user_type_id','institution_id','academic_program_id',
                'company_name','company_address',
                'profile_photo','password',
            ];

            // Transacción: si algo falla no dejamos archivos huérfanos o datos a medias
            DB::beginTransaction();

            // Aplicar cambios de foto en el payload a guardar
            if ($request->has('remove_photo')) {
                $validated['profile_photo'] = null;
            }
            if ($newRelativePath !== null) {
                $validated['profile_photo'] = $newRelativePath;
            }

            // Fill seguro
            $user->fill(Arr::only($validated, $allowed));

            // Relaciones opcionales a null si vienen vacías
            if ($request->has('academic_program_id')) {
                $user->academic_program_id = $request->input('academic_program_id') ?: null;
            }
            if ($request->has('institution_id')) {
                $user->institution_id = $request->input('institution_id') ?: null;
            }

            $user->save();

            // Roles (si vino)
            if ($request->has('role')) {
                $roleName ? $user->syncRoles([$roleName]) : $user->syncRoles([]);
            }

            DB::commit();

            // Limpieza: si cambiamos la foto y hay una anterior diferente, borra el archivo viejo
            if ($newRelativePath && $oldRelativePath && $oldRelativePath !== $newRelativePath) {
                $oldPath = storage_path('app/public/'.$oldRelativePath);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            // Si pidió remover foto, borra la anterior
            if ($request->boolean('remove_photo') && $oldRelativePath) {
                $oldPath = storage_path('app/public/'.$oldRelativePath);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            return $request->expectsJson()
                ? response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado exitosamente',
                    'user'    => $user->fresh(),
                ], 200)
                : redirect()->route('profile.edit', $user->id)->with('success', 'Perfil actualizado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'errors' => $e->errors()], 422)
                : back()->withErrors($e->errors())->withInput();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('profile.update 500', [
                'user_id' => $user->id ?? null,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return $request->expectsJson()
                ? response()->json([
                    'success'   => false,
                    'message'   => 'Error inesperado en el servidor',
                    'exception' => config('app.debug') ? get_class($e) : null,
                    'error'     => config('app.debug') ? $e->getMessage() : null,
                ], 500)
                : back()->with('error', 'Ocurrió un error inesperado.')->withInput();
        }
    }
}
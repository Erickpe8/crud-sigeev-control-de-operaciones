<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiRequest;


class RegisterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * rfc: Valida que el formato del correo sea válido según la norma RFC .
     * dns: Verifica que el dominio del correo tenga registros DNS válidos (es decir, que exista realmente un servidor de correo asociado a ese dominio).
     * spoof: Intenta detectar si el correo electrónico podría ser una dirección suplantada.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'birthdate'     => 'required|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB máximo

            'gender_id'           => 'required|exists:genders,id',
            'document_type_id'    => 'required|exists:document_types,id',
            'user_type_id'        => 'required|exists:user_types,id',
            'academic_program_id' => 'nullable|exists:academic_programs,id',

            'document_number'     => 'required|string|max:255|min:3|unique:users,document_number',

            'institution_id'  => 'nullable|exists:institutions,id',
            'company_name'    => 'nullable|string|max:255',
            'company_address' => 'nullable|string',

            'accepted_terms'  => 'required|boolean|accepted',

            'email'    => 'required|email:rfc,dns,spoof|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }


    public function messages()
    {
        // Mensajes de error personalizados para cada regla de validación
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'email' => 'El campo :attribute debe ser una dirección de correo válida.',
            'email.rfc' => 'El campo :attribute debe tener un formato RFC válido.',
            'email.dns' => 'El dominio del :attribute no parece tener un servidor válido.',
            'email.spoof' => 'El campo :attribute parece ser falso o suplantado.',
            'unique' => 'El campo :attribute ya ha sido registrado.',
            'max' => 'El campo :attribute no debe exceder los :max caracteres.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
            'exists' => 'El campo :attribute seleccionado no es válido.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
            'accepted' => 'Debes aceptar los términos y condiciones.',
            'image' => 'El archivo de :attribute debe ser una imagen.',
            'mimes' => 'El archivo de :attribute debe ser de tipo: :values.',
        ];
    }

    public function attributes()
    {
         // Nombres personalizados para cada campo de la solicitud
        return [
            'first_name' => 'nombres',
            'last_name' => 'apellidos',
            'birthdate' => 'fecha de nacimiento',
            'profile_photo' => 'foto de perfil',

            'gender_id' => 'género',
            'document_type_id' => 'tipo de documento',
            'user_type_id' => 'tipo de usuario',
            'academic_program_id' => 'programa académico',

            'document_number' => 'número de documento',

            'institution_id' => 'institución',
            'company_name' => 'nombre de la compañía',
            'company_address' => 'dirección de la compañía',

            'accepted_terms' => 'términos y condiciones',

            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
        ];
    }
}

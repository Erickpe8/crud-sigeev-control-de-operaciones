<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
      /**
     * Sobrescribe el manejo de una validación fallida.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // Devolver una respuesta JSON cuando la validación falla
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }

    /**
     * Sobrescribe el manejo de una autorización fallida.
     *
     * @throws \Illuminate\Http\Exceptions.HttpResponseException
     */
    protected function failedAuthorization()
    {
        // Devuelve una respuesta JSON personalizada cuando la autorización falla
        throw new HttpResponseException(response()->json([
            'success' => false,
            'messages' => [ 
                'authorization' => 'Authorization failed.',
                'detail' => 'No estás autorizado para realizar esta acción debido a las restricciones de validación del request.',
            ],
        ], 403));  // Devuelve un código HTTP 403 Forbidden
    }
}

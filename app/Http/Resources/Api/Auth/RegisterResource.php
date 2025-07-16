<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'uuid'         => $this->uuid,
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'email'        => $this->email,
            'birthdate'    => $this->birthdate,
            'profile_photo'=> $this->profile_photo,

            'gender_id'         => $this->gender_id,
            'document_type_id'  => $this->document_type_id,
            'user_type_id'      => $this->user_type_id,
            'academic_program_id' => $this->academic_program_id,

            'document_number' => $this->document_number,

            'institution'     => $this->institution,
            'company_name'    => $this->company_name,
            'company_address' => $this->company_address,

            'accepted_terms' => $this->accepted_terms,
            
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    public function with($request)
        {
            return [
                'token' => $this->createToken('auth_token')->plainTextToken, // Genera el token aquí
                'token_type' => 'Bearer',
            ];
        }
}

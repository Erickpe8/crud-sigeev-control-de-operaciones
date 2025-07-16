<?php

namespace App\Http\Resources\Api\UserType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexUserTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [
            'id' => $this->id,
            'name' => $this->type,
        ];
    }
}

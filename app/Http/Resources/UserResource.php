<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        {
            return [
                'id'           => $this->id,
                'name'         => $this->name,
                'email'        => $this->email,
                'account_type' => $this->account_type,
                'company_id'   => $this->company_id,
                'company'      => $this->whenLoaded('company'), // Eager loaded if needed
                'roles'        => $this->roles->pluck('name'), // Spatie roles
                'blocked'      => $this->blocked ?? false,
                'created_at'   => $this->created_at?->toDateTimeString(),
                'updated_at'   => $this->updated_at?->toDateTimeString(),
            ];
        }
        
    }
}

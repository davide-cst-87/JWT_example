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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'badge_id' => $this->badge_id,
            // 'image' => $this->image,
            'image' => $this->image ? asset('storage/'.$this->image) : null,

            'initials' => strtoupper(substr($this->name, 0, 1).substr($this->surname, 0, 1)),

            'account_type' => $this->account_type,
            'company_id' => $this->company_id,
            'company' => $this->whenLoaded('company'),
            'roles' => $this->roles->pluck('name'),
            'is_blocked' => $this->is_blocked ?? false,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];

    }
}

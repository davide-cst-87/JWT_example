<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScanResource extends JsonResource
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
            'badge_id' => $this->badge_id,
            'type' => $this->type,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'surname' => $this->user?->surname,
            ],
        ];
    }
}

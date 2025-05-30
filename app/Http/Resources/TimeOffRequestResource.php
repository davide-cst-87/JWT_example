<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeOffRequestResource extends JsonResource
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
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'surname' => $this->user->surname,
                    'email' => $this->user->email,
                ];
            }),

            $this->mergeWhen($request->routeIs('timeOff.show'), [
                    'updated_at' => $this->updated_at->toDateTimeString(),
                    'note' => $this->note,
                    'approved_by' => $this->approvedBy ? [
                        'id' => $this->approvedBy->id,
                        'name' => $this->approvedBy->name,
                    ] : null,
                ]),

        ];
    }
}

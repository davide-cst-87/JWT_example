<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeOffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'sometimes|in:holiday,sickness,other',
            'start_date' => 'sometimes|date|after_or_equal:today',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'note' => 'nullable|string|max:1000',
            'status' => 'prohibited',
            'approved_by' => 'prohibited',
            'user_id' => 'prohibited',
        ];
    }

    public function mappedAttributes(): array
    {
        $attributeMap = [
            'type' => 'type',
            'start_date' => 'start_date',
            'end_date' => 'end_date',
            'note' => 'note',
        ];

        $attributesToUpdate = [];

        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }

    public function messages(): array
    {
        return [
            'status.prohibited' => 'You are not allowed to modify the status of a time off request.',
            'approved_by.prohibited' => 'You cannot assign approval yourself.',
            'user_id.prohibited' => 'You cannot change the ownership of this request.',
        ];
    }
}

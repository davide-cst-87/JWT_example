<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeOffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:holiday,sickness,other',
            'start_date' => 'required:date',
            'end_date' => 'required|date',
            'note' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'The type you selected is invalid. Allowed values are: holiday, sickness, or other.',
            'type.required' => 'The type of time off is required.',
            'start_date.required' => 'Please provide a start date.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'Please provide an end date.',
            'end_date.date' => 'The end date must be a valid date.',
        ];
    }
}

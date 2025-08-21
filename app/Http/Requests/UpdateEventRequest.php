<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'capacity' => 'required|integer|min:1|max:10000',
            'ticket_price' => 'required|numeric|min:0|max:9999.99',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Event name is required.',
            'location.required' => 'Event location is required.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after the start date.',
            'capacity.required' => 'Event capacity is required.',
            'capacity.min' => 'Capacity must be at least 1.',
            'capacity.max' => 'Capacity cannot exceed 10,000.',
            'ticket_price.required' => 'Ticket price is required.',
            'ticket_price.min' => 'Ticket price cannot be negative.',
        ];
    }
}

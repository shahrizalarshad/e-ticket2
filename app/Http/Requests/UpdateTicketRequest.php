<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:1|max:10',
            'status' => 'required|in:pending,confirmed,cancelled',
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
            'buyer_name.required' => 'Buyer name is required.',
            'buyer_email.required' => 'Buyer email is required.',
            'buyer_email.email' => 'Please provide a valid email address.',
            'quantity.required' => 'Quantity is required.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Maximum 10 tickets per purchase.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be pending, confirmed, or cancelled.',
        ];
    }
}

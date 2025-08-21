<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTicketRequest extends FormRequest
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
            'event_id' => 'required|exists:events,id',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $eventId = request()->input('event_id');
            $quantity = request()->input('quantity', 0);
            $user = auth()->user();

            if ($eventId) {
                $event = Event::find($eventId);
                
                if ($event) {
                    // Check if event has passed
                    if ($event->hasPassed()) {
                        $validator->errors()->add('event_id', 'Cannot book tickets for past events.');
                    }

                    // Check VIP access restrictions
                    if (!$event->canUserBook($user)) {
                        $validator->errors()->add('event_id', 'This event is currently in VIP access period. Only VIP members can book tickets.');
                    }

                    // Check ticket availability
                    if (!$event->hasAvailableTickets()) {
                        $validator->errors()->add('quantity', 'This event is sold out.');
                    } elseif ($event->available_tickets < $quantity) {
                        $validator->errors()->add('quantity', "Not enough tickets available. Requested: {$quantity}, Available: {$event->available_tickets}");
                    }
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'buyer_name.required' => 'Full name is required.',
            'buyer_name.string' => 'Full name must be a valid text.',
            'buyer_name.max' => 'Full name cannot exceed 255 characters.',
            'buyer_email.required' => 'Email address is required.',
            'buyer_email.email' => 'Please enter a valid email address.',
            'buyer_email.max' => 'Email address cannot exceed 255 characters.',
            'quantity.required' => 'Please select the number of tickets.',
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'You must purchase at least 1 ticket.',
            'quantity.max' => 'You can purchase a maximum of 10 tickets at once.',
            'event_id.required' => 'Event selection is required.',
            'event_id.exists' => 'The selected event is invalid.',
        ];
    }
}

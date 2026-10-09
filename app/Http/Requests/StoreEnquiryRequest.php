<?php

namespace App\Http\Requests;

use App\Enums\EnquiryType;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Public enquiry / test-ride form submitted from the homepage.
 */
class StoreEnquiryRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(EnquiryType::class)],
            'motorcycle_id' => [
                Rule::requiredIf($this->input('type') === EnquiryType::TestRide->value),
                'nullable',
                'integer',
                Rule::exists('motorcycles', 'id')->where('is_published', true),
            ],
            'showroom_id' => ['nullable', 'integer', Rule::exists('showrooms', 'id')],
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30', new PhoneNumber],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today', 'before:+6 months'],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'motorcycle_id.required' => 'Please choose the model you would like to test ride.',
        ];
    }
}

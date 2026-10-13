<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !str_starts_with($value, '+')) {
            $fail('Please enter a full international phone number.');
            return;
        }

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $number = $phoneUtil->parse($value, null);

            if (!$phoneUtil->isValidNumber($number)) {
                $fail('Please enter a valid phone number.');
            }
        } catch (NumberParseException) {
            $fail('Please enter a valid phone number.');
        }
    }
}

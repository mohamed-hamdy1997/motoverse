<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Accepts international phone numbers: an optional leading "+", then 7–30
 * digits, spaces, hyphens or parentheses (e.g. "+974 5555 1234").
 */
class PhoneNumber implements ValidationRule
{
    private const string PATTERN = '/^\+?[0-9\s\-()]{7,30}$/';

    /**
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match(self::PATTERN, $value)) {
            $fail('Please enter a valid phone number.');
        }
    }
}

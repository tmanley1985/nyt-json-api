<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MultipleOfTwenty implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (! is_numeric($value)) {
            $fail($attribute.' must be a number.');
            return;
        }

        if ($value != 0 && $value % 20 != 0) {
            $fail("The {$attribute} must be 0 or a multiple of 20.");
            return;
        }
    }
}

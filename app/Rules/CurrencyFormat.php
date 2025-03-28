<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrencyFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isMatch = preg_match('/^\d{1,3}(,\d{3})*(\.\d{1,2})?$/', $value);
        if (!$isMatch) {
            $fail('The :attribute format must be like 10,000.00');
        }
    }
}

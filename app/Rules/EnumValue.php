<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnumValue implements Rule
{
    private string $enumClass;

    public function __construct(string $enumClass)
    {
        $this->enumClass = $enumClass;
    }

    public function passes($attribute, $value): bool
    {
        if (!enum_exists($this->enumClass)) {
            return false;
        }

        return in_array($value, array_column($this->enumClass::cases(), 'value'));
    }

    public function message(): string
    {
        return 'The :attribute field is invalid.';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedPageSizeRule implements Rule
{

    const ALLOWED_PAGE_SIZE = [10, 25, 50, 100];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array($value, self::ALLOWED_PAGE_SIZE);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute value is not allowed. (Allowed: [10, 25, 50, 100])";
    }
}

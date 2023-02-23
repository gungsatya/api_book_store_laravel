<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LimitBookPriceRule implements Rule
{
    const BOTTOM_LIMIT_BOOK_PRICE = 1000;

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
        return $value >= self::BOTTOM_LIMIT_BOOK_PRICE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "Minimum book's price is 1000.";
    }
}

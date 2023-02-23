<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagIdsSearchRule implements Rule
{
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
    public function passes($attribute, $value)
    {
        $ids = collect(explode(',', $value));

        return $ids->every(function ($id) {
            return is_int(intval($id));
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must be integer';
    }
}

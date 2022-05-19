<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberUa implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[\+]{0,1}380([0-9]{9})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Phone number must start with code of Ukraine (+380 or 380) and contains 9 numbers after.';
    }
}

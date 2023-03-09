<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class classIsOneOf implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value == 'S1' ||
                $value == 'S2'||
                $value == 'S3'||
                $value == 'S4'||
                $value == 'S5'||
                $value == 'S6';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Use the correct format for class e.g S1 for Senior One. Refer to instruction No.3';
    }


}

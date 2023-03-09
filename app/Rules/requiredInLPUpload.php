<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class requiredInLPUpload implements Rule
{
    public $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($field)
    {
        $this->field = $field;
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
        return $attribute && $value != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ' . $this->field . ' is required';
    }
}

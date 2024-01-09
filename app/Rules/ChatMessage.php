<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ChatMessage implements Rule
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
        $validator1 = Validator::make([ $attribute => $value ], [
            $attribute => 'image|max:5120',
        ]);

        $validator2 = Validator::make([ $attribute => $value ], [
            $attribute => 'array|min:1',
            $attribute . '.*' => 'image|max:5120',
        ]);

        $validator3 = Validator::make([ $attribute => $value ], [
            $attribute => 'string|max:2000',
        ]);

        return $validator1->passes() || $validator2->passes()
            || $validator3->passes();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The message format is invalid.';
    }
}

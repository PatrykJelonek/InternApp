<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Attachments implements Rule
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
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            foreach ($value as $attachment) {
                if (empty($attachment['name'])) {
                    return false;
                }

                if (empty($attachment['mime']) && !in_array(
                        $attachment['mime'],
                        config('global.acceptableAttachmentsMimeTypes'),
                        false
                    )) {
                    return false;
                }

                if (empty($attachment['content'])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Przekazano zły załącznik.';
    }
}

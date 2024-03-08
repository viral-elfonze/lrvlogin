<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileOrString implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the value is either a file or a string
        return is_string($value) || $value instanceof \Illuminate\Http\UploadedFile;
    }

    public function message()
    {
        return 'The :attribute must be either a file or a string.';
    }
}

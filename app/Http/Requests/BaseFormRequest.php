<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }

    protected function defaultPostInputValidation(string $key): ?string
    {
        $value = $this->post($key);
        return $value !== null ? strip_tags($value) : null;
    }
}
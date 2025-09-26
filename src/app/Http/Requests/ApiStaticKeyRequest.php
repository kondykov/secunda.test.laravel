<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiStaticKeyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'key' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

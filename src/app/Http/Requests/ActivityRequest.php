<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'is_category' => ['nullable', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:activities,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

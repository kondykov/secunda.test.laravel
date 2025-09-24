<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'activity_category_id' => ['required', 'exists:activity_categories,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

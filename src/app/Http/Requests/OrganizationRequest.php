<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'phones' => ['required'],
            'building_id' => ['required', 'exists:buildings,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

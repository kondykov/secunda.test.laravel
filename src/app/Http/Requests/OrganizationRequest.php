<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('organizations', 'name')->ignore($this->route('organization'))],
            'phones' => ['required'],
            'building_id' => ['required', 'exists:buildings,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable'],
            'address' => ['required'],
            'longitude' => ['required'],
            'latitude' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

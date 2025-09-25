<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizationActivityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization_id' => [
                'required',
                'exists:organizations,id',
                Rule::unique('organization_activities')
                    ->where('activity_id', $this->activity_id)
                    ->ignore($this->route('organization_activities'))
            ],
            'activity_id' => [
                'required',
                'exists:activities,id',
                Rule::unique('organization_activities')
                    ->where('organization_id', $this->organization_id)
                    ->ignore($this->route('organization_activities'))
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

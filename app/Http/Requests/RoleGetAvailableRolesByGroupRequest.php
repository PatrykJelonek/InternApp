<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleGetAvailableRolesByGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'groups' => [
                'sometimes',
                'array',
                Rule::in(RoleConstants::ROLE_GROUPS),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'groups.array' => 'Wartość musi być tablicą',
            'groups.in' => 'Wartość nie jest prawidłowa',
        ];
    }
}

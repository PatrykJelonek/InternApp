<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UniversityRejectUniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole([RoleConstants::ROLE_ADMIN]);
    }

    public function all($keys = null): ?array
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|exists:App\Models\University,slug',
            'reason' => 'required'
        ];
    }
}

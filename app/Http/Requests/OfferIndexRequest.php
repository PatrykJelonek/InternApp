<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OfferIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->hasRole([RoleConstants::ROLE_ADMIN])) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories' => 'sometimes|array',
            'statuses' => 'sometimes|array',
            'limit' => 'sometimes|array',
        ];
    }
}

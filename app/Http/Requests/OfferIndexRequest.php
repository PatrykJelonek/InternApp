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
        return true;
    }

    public function all($keys = null): array
    {
        $data = parent::all();

        if (Auth::user()->hasRole([RoleConstants::ROLE_ADMIN])) {
            $data['categories'] = ['accepted'];
        }

        return $data;
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

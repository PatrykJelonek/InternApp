<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserActivateUserRequest extends FormRequest
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

    public function all($keys = null)
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'activationToken' => 'required|exists:App\Models\User,activation_token'
        ];
    }

    public function messages()
    {
        return [
          'activationToken.required' => 'Token aktywacyjny jest wymagany!',
          'activationToken.exists' => 'Nie można dopasować tokenu do konta!'
        ];
    }
}

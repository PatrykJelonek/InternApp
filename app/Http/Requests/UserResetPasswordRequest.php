<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserResetPasswordRequest extends FormRequest
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
            'token' => 'required',
            'password' => 'required',
            'passwordRepeat' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
          'token.required' => 'Token jest wymagany!',
          'password.required' => 'Hasło jest wymagane!',
          'passwordRepeat.required' => 'Pole jest wymagane!',
          'passwordRepeat.same' => 'Hasła nie są identyczne!',
        ];
    }
}

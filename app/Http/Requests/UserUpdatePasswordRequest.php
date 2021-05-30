<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (Auth::user()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'oldPassword' => ['required', new MatchOldPassword],
            'newPassword' => 'required',
            'newPasswordRepeat' => 'required|same:newPassword'
        ];
    }

    public function messages(): array
    {
        return [
            'oldPassword.required' => 'Stare hasło jest wymagane!',
            'newPassword.required' => 'Nowe hasło jest wymagane!',
            'newPasswordRepeat.required' => 'Powtórzenie nowego hasła jest wymagane!',
            'newPasswordRepeat.same' => 'Nowe hasła nie są identyczne!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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

    /**
     * Zasady walidacji danych rejestracyjnych po stronie serwera
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'phone' => 'required|max:16',
            'email' => 'required|unique:users|max:64',
            'password' => [
                'required',
                'string',
                'min:6',              // musi zawierać min. 6 znaków
                'regex:/[a-z]/',      // musi zawierać min. 1 małą literę
                'regex:/[A-Z]/',      // musi zawierać min. 1 dużą literę
                'regex:/[0-9]/',      // musi zawierać min. 1 cyfrę
                'regex:/[@$!%*#?&]/', // musi zawierać min. 1 znak specjalny
            ],
        ];
    }

    /**
     * Tablica zwracanych komunikatów w razie wystąpienia błędu walidacji
     *
     * @return array
     */
    function messages(): array
    {
        return [
            'firstName.required' => 'Imię jest wymagane!',
            'firstName.max' => 'Imię może zawierać maksymalnie 64 znaki!',
            'lastName.required' => 'Nazwisko jest wymagane!',
            'lastName.max' => 'Nazwisko może zawierać maksymalnie 64 znaki!',
            'phone.required' => 'Numer telefonu jest wymagane!',
            'phone.max' => 'Numer telefonu może zawierać maksymalnie 16 znaków!',
            'email.required' => 'Adres email jest wymagane!',
            'email.unique' => 'Podany adres email jest już używany w aplikacji!',
            'email.max' => 'Adres email może zawierać maksymalnie 64 znaki!',
            'password.required' => 'Hasło jest wymagane!',
            'password.max' => 'Hasło może zawierać maksymalnie 255 znaków!',
            'password.min' => 'Hasło musi mieć minimum 6 znaków!',
            'password.regex' => 'Hasło jest zbyt proste!'
        ];
    }
}

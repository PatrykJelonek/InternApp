<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityCreateUniversityRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:universities|max:255',
            'universityTypeId' => 'required|exists:App\Models\UniversityType,id',
            'cityId' => 'required|exists:App\Models\City,id',
            'street' => 'required|max:64',
            'streetNumber' => 'required|max:8',
            'email' => 'required|email|max:64',
            'phone' => 'required|max:16',
            'website' => 'required|max:64',
            'userId' => 'sometimes|exists:App\Models\User,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa uczelni jest wymagana!',
            'universityTypeId:required' => 'Rodzaj uczelni jest wymagany!',
            'universityTypeId:exists' => 'Rodzaj uczelni nie istnieje!',
            'cityId:required' => 'Miasto jest wymagane!',
            'cityId:exists' => 'Miasto nie istnieje!',
            'street:required' => 'Ulica jest wymagana!',
            'streetNumber:required' => 'Numer budynku jest wymagany!',
            'email:required' => 'Email jest wymagany!',
            'phone:required' => 'Numer telefonu jest wymagany!',
            'website:required' => 'Strona internetowa jest wymagana!',
            'userId:exists' => 'Podany użytkownik nie istnieje!',
        ];
    }
}

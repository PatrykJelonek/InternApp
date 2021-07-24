<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateCompanyRequest extends FormRequest
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
            'name' => 'required|unique:companies|max:255',
            'companyCategoryId' => 'required|exists:App\Models\CompanyCategory,id',
            'cityId' => 'required|exists:App\Models\City,id',
            'street' => 'required|max:64',
            'streetNumber' => 'required|max:8',
            'email' => 'required|email|max:64',
            'phone' => 'sometimes|max:16',
            'website' => 'sometimes|max:64',
            'description' => 'sometimes|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa firmy jest wymagana!',
            'name.unique' => 'Firma o podanej nazwie istnieje już w naszym serwisie!',
            'companyCategoryId:required' => 'Kategoria firmy jest wymagana!',
            'companyCategoryId:exits' => 'Podana kategoria firmy nie istnieje!',
            'cityId:required' => 'Miasto jest wymagane!',
            'cityId:exits' => 'Podane miasto nie istnieje!',
            'street:required' => 'Ulica jest wymagana!',
            'streetNumber:required' => 'Numer budynku jest wymagany!',
            'email:required' => 'Email jest wymagany!',
            'phone:required' => 'Numer telefonu jest wymagany!',
            'website:required' => 'Strona internetowa jest wymagana!',
            'description:required' => 'Opis firmy jest wymagany'
        ];
    }
}

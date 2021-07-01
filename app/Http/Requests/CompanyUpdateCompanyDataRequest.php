<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateCompanyDataRequest extends FormRequest
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

    public function all($keys = null): ?array
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
            'slug' => 'required|exists:App\Models\Company,slug',
            'email' => 'sometimes|email|max:64',
            'phone' => 'sometimes|max:16',
            'website' => 'sometimes|url',
            'description' => 'sometimes|max:255'
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'Slug firmy jest wymagany!',
            'slug.exists' => 'Podana firma nie istnieje!',
            'email.email' => 'Podany adres email jest nieprawidłowy!',
            'email.max' => 'Adres email nie może przekraczać 64 znaków!',
            'phone.max' => 'Numer telefonu nie może przekraczać 16 znaków!',
            'website.url' => 'Adres strony internetowej ma nieprawidłowy format!',
            'description.max' => 'Opis nie może być dłuższy niż 255 znaków!'
        ];
    }
}

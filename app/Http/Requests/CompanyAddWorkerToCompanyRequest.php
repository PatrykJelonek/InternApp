<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAddWorkerToCompanyRequest extends FormRequest
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
            'slug' => 'required|exists:App\Models\Company,slug',
            'userId' => 'required|exists:App\Models\User,id',
            'accessCode' => 'required|max:8|exists:App\Models\Company,access_code',
        ];
    }

    public function messages()
    {
        return [
            'slug.exists' => 'Podana firma nie istnieje',
            'userId.exists' => 'Podany użytkownik nie istnieje',
            'accessCode.exists' => 'Podany kod dostępu nie pasuje do żadnej firmy',
            'slug.required' => 'Slug firmy jest wymagany',
            'userId.required' => 'ID użytkownika jest wymagane',
            'accessCode.required' => 'Kod dostępu jest wymagany',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgreementDeleteAgreementRequest extends FormRequest
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
            'slug' => 'required|exists:App\Models\Agreement,slug',
        ];
    }

    public function messages()
    {
        return [
          'slug.required' => 'Slug umowy jest wymagany!',
          'slug.exists' => 'Podana umowa nie istnieje!'
        ];
    }
}

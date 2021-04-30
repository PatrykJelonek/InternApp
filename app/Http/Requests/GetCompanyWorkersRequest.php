<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCompanyWorkersRequest extends FormRequest
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
        $data['slug'] = $this->route('slug');

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
            'slug' => 'required|exists:App\Models\Company,slug',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.required' => 'Podaj poprawny adres firmy.',
            'slug.exists' => 'Podana firma nie istnieje.',
        ];
    }
}

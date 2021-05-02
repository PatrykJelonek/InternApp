<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgreementShowRequest extends FormRequest
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
        clock()->info('DUMO', ['dump' => (array) $this->route()]);
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
            'slug' => 'required|exists:App\Models\Agreement,slug',
        ];
    }

    public function messages()
    {
        return [
          'slug.required' => 'Nie podano adresu umowy.',
          'slug.exists' => 'Podana umowa nie istnieje.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityCreateUniversityFacultyRequest extends FormRequest
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
            'slug' => 'required|exists:App\Models\University,slug',
            'name' => 'required|max:128',
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'Slug uczelni jest wymagany!',
            'slug.exists' => 'Podana uczelnia nie istnieje!',
            'name.required' => 'Nazwa wydziału jest wymagana!',
            'name.max' => 'Nazwa nie może mieć więcej niż 128 znaków!',
        ];
    }
}

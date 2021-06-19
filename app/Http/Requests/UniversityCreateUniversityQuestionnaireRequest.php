<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityCreateUniversityQuestionnaireRequest extends FormRequest
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
            'name' => 'required|max:64',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'Slug firmy jest wymagany!',
            'name.required' => 'Nazwa ankiety jest wymagana!',
            'name.max' => 'Długość nazwy nie może przekraczać 64 znaków!',
            'description' => 'Opis ankiety jest wymagany!',
        ];
    }
}

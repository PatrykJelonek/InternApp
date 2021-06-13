<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireCreateQuestionnaireRequest extends FormRequest
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
            'name' => 'required|string|max:64',
            'description' => 'string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa jest wymagana!',
            'name.string' => 'Nazwa powinna być tekstem!',
            'name.max' => 'Nazwa może zawierać maksymalnie 64 znaki!',
            'description.string' => 'Opis powinien być tekstem!',
            'description.max' => 'Opis może zawierać maksymalnie 255 znaki!'
        ];
    }
}

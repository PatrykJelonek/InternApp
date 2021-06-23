<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireUpdateQuestionnaireRequest extends FormRequest
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
        $data = parent::all();
        $data['questionnaireId'] = $this->route('questionnaireId');

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
            'questionnaireId' => 'required|exists:App\Models\Questionnaire,id',
            'name' => 'required|max:64',
            'description' => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'questionnaireId.required' => 'Id ankiety jest wymagane!',
            'questionnaireId.exists' => 'Podana ankieta nie istnieje!',
            'name.required' => 'Nazwa ankiety jest wymagana!',
            'name.max' => 'Nazwa ankiety nie może przekraczać 64 znaków!',
            'description.string' => 'Opis musi być tekstem!',
        ];
    }
}

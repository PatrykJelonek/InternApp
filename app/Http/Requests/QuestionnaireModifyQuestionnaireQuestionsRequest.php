<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireModifyQuestionnaireQuestionsRequest extends FormRequest
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
            'questions' => 'required|array',
            'questions.*.questionnaire_id' => 'required|int|exists:App\Models\Questionnaire,id',
            'questions.*.content' => 'required|max:128',
            'questions.*.description' => 'sometimes|max:255',
            'questions.*.position' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'questions.required' => 'Tablica pytań jest wymagana!',
            'questions.array' => 'Pytania muszą być w tablicy!',
            'questions.*.questionnaire_id.required' => 'Id ankiety jest wymagane!',
            'questions.*.questionnaire_id.int' => 'Id ankiety musi być liczbą!',
            'questions.*.questionnaire_id.exists' => 'Podana ankieta nie istnieje!',
            'questions.*.content.required' => 'Treść pytania jest wymagana!',
            'questions.*.content.max' => 'Treść pytania nie może przekraczać 128 znaków!',
            'questions.*.description.max' => 'Opis pytania nie może przekraczać 255 znaków!',
            'questions.*.position.required' => 'Pozycja pytania jest wymagana!',
            'questions.*.position.int' => 'Pozycja musi być liczbą!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuestionnaireAddQuestionnaireAnswersRequest extends FormRequest
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
        clock()->info('dum', $this->input('answers'));
        $data = parent::all();
        $data['userId'] = Auth::user()->hasRole([RoleConstants::ROLE_ADMIN]) ? $this->input('userId') : null;

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
            'answers' => 'required|array',
            'answers.*.questionnaireQuestionId' => 'required|exists:App\Models\QuestionnaireQuestion,id',
            'answers.*.content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'answers.required' => 'Odpowiedzi są wymagane!',
            'answers.questionnaireQuestionId.required' => 'Id pytania jest wymagane!',
            'answers.questionnaireQuestionId.exists' => 'Pytanie nie istnieje!',
            'answers.content.required' => 'Treść odpowiedzi jest wymagana!',
        ];
    }
}

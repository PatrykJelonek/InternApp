<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 13/06/2021
 * Time: 13:59
 */

namespace App\Repositories;

use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireQuestionAnswer;
use App\Repositories\Interfaces\QuestionnairesRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class QuestionnairesRepository implements QuestionnairesRepositoryInterface
{

    public function getAllQuestionnaires()
    {
        return Questionnaire::all();
    }

    public function getQuestionnaire(int $questionnaireId)
    {
        return Questionnaire::with(['questions'])->find($questionnaireId);
    }

    public function getQuestionnaireRoles(int $questionnaireId)
    {
        return Questionnaire::find($questionnaireId)->roles;
    }

    public function getQuestionnaireQuestions(int $questionnaireId)
    {
        $questionnaire = Questionnaire::find($questionnaireId);

        if (!empty($questionnaire)) {
            return $questionnaire->questions()->orderBy('position')->get();
        }

        return [];
    }

    public function getQuestionAnswers(int $questionId)
    {
        return QuestionnaireQuestion::find($questionId)->answers();
    }

    public function getQuestionnaireAnswers(int $questionnaireId): array
    {
        $answers = QuestionnaireQuestionAnswer::with('question')->whereHas(
            'question',
            function (Builder $query) use ($questionnaireId) {
                $query->where(['questionnaire_id' => $questionnaireId]);
            }
        )->get();

        $answersBySessionUuid = [];

        foreach ($answers as $answer) {
            $answersBySessionUuid[$answer->session_uuid][] = $answer;
        }

        return $answersBySessionUuid;
    }

    public function getQuestionnaireAnswerStatisticsByWeek(int $questionnaireId)
    {
        return QuestionnaireQuestionAnswer::whereHas(
            'question',
            function (Builder $query) use ($questionnaireId) {
                $query->where(['questionnaire_id' => $questionnaireId]);
            }
        )->get()->groupBy('questionnaire_question_id');
    }
}

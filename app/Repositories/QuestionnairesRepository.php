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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QuestionnairesRepository implements QuestionnairesRepositoryInterface
{

    public function getAllQuestionnaires()
    {
        return Questionnaire::all();
    }


    public function getQuestionnaire(int $questionnaireId)
    {
        return Questionnaire::find($questionnaireId);
    }

    public function getQuestionnaireRoles(int $questionnaireId)
    {
        return Questionnaire::find($questionnaireId)->roles;
    }

    public function getQuestionnaireQuestions(int $questionnaireId)
    {
        return Questionnaire::find($questionnaireId)->questions;
    }

    public function getQuestionAnswers(int $questionId)
    {
        return QuestionnaireQuestion::find($questionId)->answers();
    }

    public function getQuestionnaireAnswerStatisticsByWeek(int $questionnaireId)
    {
        return QuestionnaireQuestionAnswer::whereHas(
            'question',
            function (Builder $query) use ($questionnaireId) {
                $query->where(['questionnaire_id' => $questionnaireId]);
            }
        )->get()->keyBy(function ($val) {
            return Carbon::parse($val['created_at'])->format('m');
        })->groupBy(
            function ($val) {
                return Carbon::parse($val->created_at)->format('m');
            }
        );
    }
}

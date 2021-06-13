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
use App\Repositories\Interfaces\QuestionnairesRepositoryInterface;

class QuestionnairesRepository implements QuestionnairesRepositoryInterface
{

    public function getAllQuestionnaires()
    {
        return Questionnaire::all();
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
}

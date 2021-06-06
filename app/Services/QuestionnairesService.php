<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 06/06/2021
 * Time: 21:51
 */


namespace App\Services;

use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireQuestionAnswer;

class QuestionnairesService
{
    /**
     * @param string $name
     * @param string $description
     *
     * @return Questionnaire|null
     */
    public function createQuestionnaire(string $name, string $description): ?Questionnaire
    {
        $questionnaire = new Questionnaire();
        $questionnaire->name = $name;
        $questionnaire->description = $description;
        $questionnaire->freshTimestamp();

        if ($questionnaire->save()) {
            return $questionnaire;
        }

        return null;
    }

    /**
     * @param int    $questionnaireId
     * @param string $content
     * @param string $description
     *
     * @return QuestionnaireQuestion|null
     */
    public function createQuestion(int $questionnaireId, string $content, string $description): ?QuestionnaireQuestion
    {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_id = $questionnaireId;
        $question->content = $content;
        $question->description = $description;
        $question->freshTimestamp();

        if ($question->save()) {
            return $question;
        }

        return null;
    }

    /**
     * @param int    $questionId
     * @param int    $userId
     * @param string $content
     *
     * @return QuestionnaireQuestionAnswer|null
     */
    public function createAnswer(int $questionId, int $userId, string $content): ?QuestionnaireQuestionAnswer
    {
        $answer = new QuestionnaireQuestionAnswer();
        $answer->questionnaire_question_id = $questionId;
        $answer->user_id = $userId;
        $answer->content = $content;
        $answer->freshTimestamp();

        if ($answer->save()) {
            return $answer;
        }

        return null;
    }

    /**
     * @param int $roleId
     * @param int $questionnaireId
     *
     * @return mixed
     */
    public function addRoleToQuestionnaire(int $roleId, int $questionnaireId)
    {
        $questionnaire = Questionnaire::find($questionnaireId);
        $questionnaire->roles()->attach($roleId);

        return $questionnaire;
    }
}

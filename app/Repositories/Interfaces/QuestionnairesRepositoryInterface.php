<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 13/06/2021
 * Time: 13:58
 */

namespace App\Repositories\Interfaces;

interface QuestionnairesRepositoryInterface
{
    public function getAllQuestionnaires();

    public function getQuestionnaire(int $questionnaireId);

    public function getQuestionnaireRoles(int $questionnaireId);

    public function getQuestionnaireQuestions(int $questionnaireId);

    public function getQuestionAnswers(int $questionId);

    public function getQuestionnaireAnswerStatisticsByWeek(int $questionnaireId);

    public function getQuestionnaireAnswers(int $questionnaireId);

    public function getQuestionnaireAuthor(int $questionnaireId);
}

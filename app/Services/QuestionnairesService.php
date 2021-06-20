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
use App\Repositories\QuestionnairesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionnairesService
{
    /**
     * @var QuestionnairesRepository
     */
    public $repository;

    /**
     * QuestionnairesService constructor.
     *
     * @param QuestionnairesRepository $repository
     */
    public function __construct(QuestionnairesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string   $name
     * @param string   $description
     * @param int|null $companyId
     * @param int|null $universityId
     *
     * @return Questionnaire|null
     */
    public function createQuestionnaire(
        string $name,
        string $description,
        ?int $companyId = null,
        ?int $universityId = null
    ): ?Questionnaire {
        $questionnaire = new Questionnaire();
        $questionnaire->name = $name;
        $questionnaire->description = $description;
        $questionnaire->company_id = $companyId;
        $questionnaire->university_id = $universityId;
        $questionnaire->freshTimestamp();

        if ($questionnaire->save()) {
            return $questionnaire;
        }

        return null;
    }

    /**
     * @param int         $questionnaireId
     * @param string      $content
     * @param string|null $description
     * @param string|null $position
     *
     * @return QuestionnaireQuestion|null
     */
    public function createQuestion(
        int $questionnaireId,
        string $content,
        ?string $description = null,
        ?string $position = null
    ): ?QuestionnaireQuestion {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_id = $questionnaireId;
        $question->content = $content;
        $question->description = $description;
        $question->position = $position;
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

    /**
     * @param int    $questionnaireId
     * @param string $name
     * @param string $description
     *
     * @return Questionnaire|null
     */
    public function updateQuestionnaire(int $questionnaireId, string $name, string $description): ?Questionnaire
    {
        $questionnaire = Questionnaire::find($questionnaireId);
        $questionnaire->name = $name;
        $questionnaire->description = $description;

        if ($questionnaire->save()) {
            return $questionnaire;
        }

        return null;
    }

    /**
     * @param int         $questionId
     * @param string      $content
     * @param string|null $description
     * @param string|null $position
     *
     * @return QuestionnaireQuestion|null
     */
    public function updateQuestion(
        int $questionId,
        string $content,
        ?string $description = null,
        ?string $position = null
    ): ?QuestionnaireQuestion {
        $question = QuestionnaireQuestion::find($questionId);
        $question->content = $content;
        $question->description = $description;
        $question->position = $position;

        if ($question->save()) {
            return $question;
        }

        return null;
    }

    /**
     * @param int $questionnaireId
     */
    public function deleteQuestionnaire(int $questionnaireId): void
    {
        $questionnaire = Questionnaire::find($questionnaireId);

        $questionnaire->delete();
    }

    /**
     * @param int $questionId
     */
    public function deleteQuestion(int $questionId): void
    {
        $question = QuestionnaireQuestion::find($questionId);

        $question->delete();
    }

    public function modifyQuestionnaireQuestions(int $questionnaireId, array $newQuestions): array
    {
        $oldQuestions = $this->repository->getQuestionnaireQuestions($questionnaireId);
        $modifiedQuestions = [];
        $deletedQuestions = [];
        $isQuestionFound = [];
        $oldQuestionsLastPosition = $this->getQuestionsLastPosition($oldQuestions);

        if (!empty($oldQuestions)) {
            foreach ($oldQuestions as $oldQuestion) {
                foreach ($newQuestions as $newQuestionKey => $newQuestion) {
                    if ($oldQuestion->id === $newQuestion['id']) {
                        $isQuestionFound[$newQuestion['id']] = true;
                        if ($newQuestion['deleted_at'] !== null) {
                            $this->deleteQuestion($oldQuestion->id);
                            $deletedQuestions[] = $newQuestion;
                            unset($newQuestions[$newQuestionKey]);
                        } elseif ($oldQuestion->content !== $newQuestion['content'] || $oldQuestion->description !== $newQuestion['description'] || $oldQuestion->position !== $newQuestion['position']) {
                            $modifiedQuestions[] = $this->updateQuestion(
                                $oldQuestion->id,
                                $newQuestion['content'],
                                $newQuestion['description'] ?? null,
                                (int)$newQuestion['position']
                            );
                            unset($newQuestions[$newQuestionKey]);
                        } else {
                            $modifiedQuestions[] = $oldQuestion;
                        }
                    }
                }
            }
        }

        if (count($modifiedQuestions) > 0) {
            $lastQuestionPosition = $modifiedQuestions[count($modifiedQuestions) - 1]->position + 1;
        } elseif ($oldQuestionsLastPosition > 0) {
            $lastQuestionPosition = $oldQuestionsLastPosition + 1;
        } else {
            $lastQuestionPosition = 1;
        }

        foreach ($newQuestions as $newQuestion) {
            if (!array_key_exists($newQuestion['id'], $isQuestionFound)) {
                $modifiedQuestions[] = $this->createQuestion(
                    $questionnaireId,
                    $newQuestion['content'],
                    $newQuestion['description'] ?? null,
                    (int)$lastQuestionPosition++,
                );
            }
        }

        if (empty($modifiedQuestions)) {
            $modifiedQuestions = $newQuestions;
        }

        return [
            'modified' => $modifiedQuestions,
            'deleted' => $deletedQuestions,
        ];
    }

    public function addQuestionnaireAnswers(array $answers, ?int $userId = null): array
    {
        $insertedAnswers = [];
        $sessionUuid = Str::uuid();

        DB::beginTransaction();
        foreach ($answers as $answer) {
            $questionnaireQuestionAnswers = new QuestionnaireQuestionAnswer();
            $questionnaireQuestionAnswers->questionnaire_question_id = $answer['questionnaireQuestionId'];
            $questionnaireQuestionAnswers->user_id = $userId ?? Auth::id();
            $questionnaireQuestionAnswers->content = $answer['content'];
            $questionnaireQuestionAnswers->session_uuid = $sessionUuid;
            $questionnaireQuestionAnswers->freshTimestamp();

            if ($questionnaireQuestionAnswers->save()) {
               $insertedAnswers[] = $questionnaireQuestionAnswers;
            } else {
                DB::rollBack();
                return [];
            }
        }

        DB::commit();
        return $insertedAnswers;
    }

    private function getQuestionsLastPosition($questions)
    {
        $lastPosition = 0;

        foreach ($questions as $question) {
            $lastPosition = $lastPosition > $question->position ? $lastPosition : $question->position;
        }

        return $lastPosition;
    }
}

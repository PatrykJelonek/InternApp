<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireCreateQuestionnaireRequest as CreateQuestionnaireRequest;
use App\Http\Requests\QuestionnaireDeleteQuestionnaireQuestionRequest as DeleteQuestionRequest;
use App\Http\Requests\QuestionnaireDeleteQuestionnaireRequest as DeleteQuestionnaireRequest;
use App\Http\Requests\QuestionnaireGetAllQuestionnairesRequest as GetAllQuestionnairesRequest;
use App\Http\Requests\QuestionnaireGetQuestionnaireAnswersRequest as GetAnswersRequest;
use App\Http\Requests\QuestionnaireGetQuestionnaireAnswerStatisticsByWeekRequest;
use App\Http\Requests\QuestionnaireGetQuestionnaireQuestionAnswersRequest as GetQuestionAnswersRequest;
use App\Http\Requests\QuestionnaireGetQuestionnaireQuestionsRequest as GetQuestionsRequest;
use App\Http\Requests\QuestionnaireGetQuestionnaireRequest as GetQuestionnaireRequest;
use App\Http\Requests\QuestionnaireModifyQuestionnaireQuestionsRequest;
use App\Http\Requests\QuestionnaireUpdateQuestionnaireQuestionRequest as UpdateQuestionRequest;
use App\Http\Requests\QuestionnaireUpdateQuestionnaireRequest as UpdateQuestionnaireRequest;
use App\Http\Requests\QuestionnaireAddQuestionnaireAnswersRequest as AddAnswersRequest;
use App\Repositories\QuestionnairesRepository;
use App\Services\QuestionnairesService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class QuestionnaireController extends Controller
{
    /**
     * @var QuestionnairesRepository
     */
    private $questionnairesRepository;

    /**
     * @var QuestionnairesService
     */
    private $questionnairesService;

    /**
     * QuestionnaireController constructor.
     *
     * @param QuestionnairesRepository $questionnairesRepository
     * @param QuestionnairesService    $questionnairesService
     */
    public function __construct(
        QuestionnairesRepository $questionnairesRepository,
        QuestionnairesService $questionnairesService
    ) {
        $this->questionnairesRepository = $questionnairesRepository;
        $this->questionnairesService = $questionnairesService;
    }

    /**
     * @param GetAllQuestionnairesRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function getQuestionnaires(GetAllQuestionnairesRequest $request)
    {
        $questionnaires = $this->questionnairesRepository->getAllQuestionnaires();

        if (!empty($questionnaires)) {
            return response($questionnaires, Response::HTTP_OK);
        }

        return response(null, response(Response::HTTP_NO_CONTENT));
    }

    /**
     * @param GetQuestionnaireRequest $request
     * @param int                     $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function getQuestionnaire(GetQuestionnaireRequest $request, int $questionnaireId)
    {
        $questionnaire = $this->questionnairesRepository->getQuestionnaire($questionnaireId);

        if (!empty($questionnaire)) {
            return response($questionnaire, Response::HTTP_OK);
        }

        return response(null, response(Response::HTTP_NO_CONTENT));
    }

    /**
     * @param GetQuestionsRequest $request
     * @param int                 $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function getQuestionnaireQuestions(GetQuestionsRequest $request, int $questionnaireId)
    {
        $questions = $this->questionnairesRepository->getQuestionnaireQuestions($questionnaireId);

        if (!empty($questions)) {
            return response($questions, Response::HTTP_OK);
        }

        return response(null, response(Response::HTTP_NO_CONTENT));
    }

    /**
     * @param GetQuestionAnswersRequest $request
     * @param int                       $questionId
     *
     * @return Application|ResponseFactory|Response
     */
    public function getQuestionnaireQuestionAnswers(GetQuestionAnswersRequest $request, int $questionId)
    {
        $answers = $this->questionnairesRepository->getQuestionAnswers($questionId);

        if (!empty($answers)) {
            return response($answers, Response::HTTP_OK);
        }

        return response(null, response(Response::HTTP_NO_CONTENT));
    }

    /**
     * @param CreateQuestionnaireRequest $request
     *
     * @return Application|ResponseFactory|Response
     */
    public function createQuestionnaire(CreateQuestionnaireRequest $request)
    {
        $result = $this->questionnairesService->createQuestionnaire(
            $request->input('name'),
            $request->input('description')
        );

        if ($result !== null) {
            return response($result, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param UpdateQuestionnaireRequest $request
     * @param                            $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function updateQuestionnaire(UpdateQuestionnaireRequest $request, $questionnaireId)
    {
        $result = $this->questionnairesService->updateQuestionnaire(
            $questionnaireId,
            $request->input('name'),
            $request->input('description')
        );

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param UpdateQuestionRequest $request
     * @param                       $questionId
     *
     * @return Application|ResponseFactory|Response
     */
    public function updateQuestionnaireQuestion(UpdateQuestionRequest $request, $questionId)
    {
        $result = $this->questionnairesService->updateQuestion(
            $questionId,
            $request->input('content'),
            $request->input('description')
        );

        if ($result !== null) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param DeleteQuestionnaireRequest $request
     * @param int                        $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function deleteQuestionnaire(DeleteQuestionnaireRequest $request, int $questionnaireId)
    {
        $this->questionnairesService->deleteQuestionnaire($questionnaireId);

        return response(null, Response::HTTP_OK);
    }

    /**
     * @param DeleteQuestionRequest $request
     * @param int                   $questionId
     *
     * @return Application|ResponseFactory|Response
     */
    public function deleteQuestionnaireQuestion(DeleteQuestionRequest $request, int $questionId)
    {
        $this->questionnairesService->deleteQuestion($questionId);

        return response(null, Response::HTTP_OK);
    }

    /**
     * @param QuestionnaireGetQuestionnaireAnswerStatisticsByWeekRequest $request
     * @param int                                                        $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function getQuestionnaireAnswerStatisticsByWeek(
        QuestionnaireGetQuestionnaireAnswerStatisticsByWeekRequest $request,
        int $questionnaireId
    ) {
        $result = $this->questionnairesRepository->getQuestionnaireAnswerStatisticsByWeek($questionnaireId);

        if (!empty($result)) {
            return response($result, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param QuestionnaireModifyQuestionnaireQuestionsRequest $request
     * @param int                                              $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function modifyQuestionnaireQuestions(
        QuestionnaireModifyQuestionnaireQuestionsRequest $request,
        int $questionnaireId
    ) {
        $result = $this->questionnairesService->modifyQuestionnaireQuestions(
            $questionnaireId,
            $request->input('questions')
        );

        if (!empty($result['modified']) || !empty($result['deleted'])) {
            return response($result['modified'] ?? [], Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param AddAnswersRequest $request
     * @param int               $questionnaireId
     *
     * @return Application|ResponseFactory|Response
     */
    public function addQuestionnaireAnswers(AddAnswersRequest $request, int $questionnaireId)
    {
        $result = $this->questionnairesService->addQuestionnaireAnswers(
            $request->input('answers'),
            $request->input('userId')
        );

        if (!empty($result)) {
            return response($result, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getQuestionnaireAnswers(GetAnswersRequest $request, int $questionnaireId)
    {
        $answers = $this->questionnairesRepository->getQuestionnaireAnswers($questionnaireId);

        return response($answers, Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionnaireQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaireQuestions = QuestionnaireQuestion::all();

        if (isset($questionnaireQuestions))
            return response($questionnaireQuestions, Response::HTTP_OK);
        else
            return response("Questionnaire Questions not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: CREATE METHOD
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionnaireQuestion = QuestionnaireQuestion::find($id);

        if (isset($questionnaireQuestion))
            return response($questionnaireQuestion, Response::HTTP_OK);
        else
            return response("Questionnaire Question not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionnaireQuestion  $questionnaireQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireQuestion $questionnaireQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionnaireQuestion  $questionnaireQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnaireQuestion $questionnaireQuestion)
    {
        //TODO:!!
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionnaireQuestion  $questionnaireQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaireQuestion = QuestionnaireQuestion::find($id);

        if ($questionnaireQuestion->delete())
            return response("Questionnaire Question has been deleted!", Response::HTTP_OK);
        else
            return response("Questionnaire Question has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

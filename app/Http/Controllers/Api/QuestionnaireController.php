<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires = Questionnaire::all();

        if (isset($questionnaires))
            return response($questionnaires, Response::HTTP_OK);
        else
            return response("Questionnaires not found!", Response::HTTP_NOT_FOUND);
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
        $questionnaire = new Questionnaire;

        if (isset($questionnaire)) {
            $questionnaire->name = $request->input("name");
            $questionnaire->display_name = $request->input("display name");
            $questionnaire->description = $request->input("description");
            $questionnaire->created_at = date('Y-m-d H:i:s');
            $questionnaire->updated_at = date('Y-m-d H:i:s');

            if ($questionnaire->save())
                return response($questionnaire, Response::HTTP_OK);
        }

        return response("Questionnaire has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionnaire = Questionnaire::find($id);

        if (isset($questionnaire))
            return response($questionnaire, Response::HTTP_OK);
        else
            return response("Questionnaire not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $questionnaire = Questionnaire::find($request->input("id"));

        if (isset($questionnaire)) {
            $questionnaire->name = $request->input("name");
            $questionnaire->display_name = $request->input("display name");
            $questionnaire->description = $request->input("description");
            $questionnaire->updated_at = date('Y-m-d H:i:s');

            if ($questionnaire->save())
                return response($questionnaire, Response::HTTP_OK);
        }

        return response("Questionnaire not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaire = Questionnaire::find($id);

        if ($questionnaire->delete())
            return response("Questionnaire has been deleted!", Response::HTTP_OK);
        else
            return response("Questionnaire has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

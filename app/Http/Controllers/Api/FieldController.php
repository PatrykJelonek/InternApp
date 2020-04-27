<?php

namespace App\Http\Controllers\Api;

use App\Field;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::all();

        if (isset($fields))
            return response($fields, Response::HTTP_OK);
        else
            return response("Fields not found!", Response::HTTP_NOT_FOUND);

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
        $field = new Field;

        $field->name = $request->input("name");
        $field->created_at = date('Y-m-d H:i:s');
        $field->updated_at = date('Y-m-d H:i:s');

        if ($field->save())
            return response($field, Response::HTTP_CREATED);
        else
            return response("field has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $field = field::find($id);

        if (isset($field))
            return response($field, Response::HTTP_OK);
        else
            return response("field not found!", Response::HTTP_NOT_FOUND);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $field = Field::find($request->input("id"));

        if (isset($field)) {
            $field->name = $request->input("name");
            $field->updated_at = date('Y-m-d H:i:s');

            if ($field->save())
                return response($field, Response::HTTP_OK);
        }

        return response("The field has not been updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::find($id);

        if ($field->delete())
            return response("The field has been deleted!", Response::HTTP_OK);
        else
            return response("The field has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

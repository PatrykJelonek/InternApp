<?php

namespace App\Http\Controllers\Api;

use App\Models\CompanyCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companyCategories = CompanyCategory::all();
        clock()->info('asd');
        if (!empty($companyCategories)) {
            return response($companyCategories, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $companyCategory = new CompanyCategory;

        if (isset($companyCategory)) {
            $companyCategory->name = $request->input("name");
            $companyCategory->description = $request->input("description");
            $companyCategory->created_at = date('Y-m-d H:i:s');
            $companyCategory->updated_at = date('Y-m-d H:i:s');

            if ($companyCategory->save())
                return response($companyCategory, Response::HTTP_OK);
        }

        return response("Company category has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $companyCategory = CompanyCategory::find($id);

        if (isset($companyCategory))
            return response($companyCategory, Response::HTTP_OK);
        else
            return response("Company category not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompanyCategory $companyCategory
     * @return Response
     */
    public function edit(CompanyCategory $companyCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CompanyCategory $companyCategory
     * @return Response
     */
    public function update(Request $request)
    {
        $companyCategory = CompanyCategory::find($request->input("id"));

        if (isset($companyCategory)) {
            $companyCategory->name = $request->input("name");
            $companyCategory->description = $request->input("description");
            $companyCategory->updated_at = date('Y-m-d H:i:s');

            if ($companyCategory->save())
                return response($companyCategory, Response::HTTP_OK);
        }

        return response("Company category not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $companyCategory = CompanyCategory::find($id);

        if ($companyCategory->delete())
            return response("Company category has been deleted!", Response::HTTP_OK);
        else
            return response("Company category has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

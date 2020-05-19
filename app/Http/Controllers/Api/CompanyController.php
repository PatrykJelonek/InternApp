<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Company::all();

        if (isset($companies))
            return response($companies, Response::HTTP_OK);
        else
            return response("Companies not found!", Response::HTTP_NOT_FOUND);
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
        $validatedData = $request->validate([
            'name' => 'required|unique:companies|max:255',
            'companyCategoryId' => 'required',
            'cityId' => 'required',
            'street' => 'required|max:64',
            'streetNumber' => 'required|max:8',
            'email' => 'required|max:64',
            'phone' => 'required|max:16',
            'website' => 'required|max:64',
            'description' => 'required|max:255',
        ], Company::messages());

        $company = new Company;

        $company->name = $request->input('name');
        $company->company_category_id = $request->input('companyCategoryId');
        $company->city_id = $request->input('cityId');
        $company->street = $request->input('street');
        $company->street_number = $request->input('streetNumber');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->website = $request->input('website');
        $company->description = $request->input('description');
        $company->created_at = date('Y-m-d H:i:s');
        $company->updated_at = date('Y-m-d H:i:s');

        if($company->save())
        {
            if($company->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')]))
                return response([
                    'status' => 'success',
                    'data' => null,
                    'message' => 'Firma została dodana!'
                ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Niestety nie udało się dodać twojej firmy!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        if (isset($company))
            return response($company, Response::HTTP_OK);
        else
            return response("Company not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //TODO: Create method to update company
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if ($company->delete())
            return response("Company has been deleted!", Response::HTTP_OK);
        else
            return response("Company has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

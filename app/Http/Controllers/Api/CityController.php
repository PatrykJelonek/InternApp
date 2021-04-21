<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::all();

        if (isset($cities))
            return response([
                'status' => 'success',
                'data' => $cities,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response("Cities not found!", Response::HTTP_NOT_FOUND);
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
        $city = new City;

        $city->name = $request->input("name");
        $city->post_code = $request->input("post_code");
        $city->created_at = date('Y-m-d H:i:s');
        $city->updated_at = date('Y-m-d H:i:s');

        if ($city->save())
            return response($city, Response::HTTP_CREATED);
        else
            return response("City has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        $city = City::find($id);

        if (isset($city))
            return response($city, Response::HTTP_OK);
        else
            return response("City not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * @param string $postcode
     *
     * @return Response
     */
    public function showByPostcode(string $postcode): Response
    {
        $city = City::where(['post_code' => $postcode])->first();

        if (!empty($city)) {
            return response($city, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param City $city
     * @return Response
     */
    public function edit(City $city)
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
        $city = City::find($request->input("id"));

        if (isset($city)) {
            $city->name = $request->input("name");
            $city->post_code = $request->input("post_code");
            $city->updated_at = date('Y-m-d H:i:s');

            if ($city->save())
                return response($city, Response::HTTP_OK);
        }

        return response("The city has not been updated!", Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if ($city->delete())
            return response("The city has been deleted!", Response::HTTP_OK);
        else
            return response("The city has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

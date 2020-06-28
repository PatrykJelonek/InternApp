<?php

namespace App\Http\Controllers\Api;

use App\Agreement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $agreements = Agreement::all();

        if (isset($agreements))
            return response([
                'status' => 'success',
                'data' => $agreements,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie znaleziono żadnej umowy!"
            ], Response::HTTP_NOT_FOUND);

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
        $vallidatedData  = $request->validate([
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'program' => 'required',
            'schedule' => 'required',
            'content' => 'required',
            'companyId' => 'required',
            'universityId' => 'required',
            'universitySupervisorId' => 'required',
            'offerId' => 'required',
        ]);

        $agreement = new Agreement;

        $agreement->signing_date = date('Y-m-d H:i:s');
        $agreement->date_from = $request->input('dateFrom');
        $agreement->date_to = $request->input('dateTo');
        $agreement->program = $request->input('program');
        $agreement->schedule = $request->input('schedule');
        $agreement->content = $request->input('content');
        $agreement->company_id = $request->input('companyId');
        $agreement->university_id = $request->input('universityId');
        $agreement->university_supervisor_id = $request->input('universitySupervisorId');
        $agreement->offer_id = $request->input('offerId');
        $agreement->user_id = auth()->id();
        $agreement->updated_at = date('Y-m-d H:i:s');
        $agreement->created_at = date('Y-m-d H:i:s');

        if($agreement->save())
        {
            return response([
                'status' => 'success',
                'data' => $agreement,
                'message' => null
            ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie udało się utworzyć umowy!'
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
        $agreement = Agreement::with(['company', 'university', 'author', 'universitySupervisor', 'offer.supervisor', 'company.city', 'university.city'])->where(['id' => $id])->get();

        if (isset($agreement))
        return response([
            'status' => 'success',
            'data' => $agreement[0],
            'message' => null
        ], Response::HTTP_OK);
    else
        return response([
            'status' => 'error',
            'data' => null,
            'message' => "Nie znaleziono umowy!"
        ], Response::HTTP_NOT_FOUND);

    }

    /**
     * Active specified agreements
     *
     * @param $id
     * @return Response
     */
    public function active($id)
    {
        $agreement = Agreement::find($id);

        $agreement->is_active = 1;

        if($agreement->save())
            return response([
                'status' => 'success',
                'data' => null,
                'message' => 'Porozumienie zostało potwierdzone!'
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie udało się potwierdzić porozumienia!"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agreement $agreement
     * @return Response
     */
    public function edit(Agreement $agreement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Agreement $agreement
     * @return Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Agreement $agreement
     * @return Response
     */
    public function destroy($id)
    {
        $agreement = Agreement::find($id);

        if ($agreement->delete())
            return response("Agreement has been deleted!", Response::HTTP_OK);
        else
            return response("Agreement has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

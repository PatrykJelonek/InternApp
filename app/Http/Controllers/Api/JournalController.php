<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\JournalEntry;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $student_id = Student::select(['id'])->where(['user_id' => auth()->id()])->first();
        $user_internships = Internship::select(['id'])->where(['student_id' => $student_id->id])->get();
        $journal_entries = JournalEntry::with(['internship.offer','internship.agreement', 'author'])->whereIn('internship_id', Arr::pluck($user_internships->toArray(), ['id']))
            ->orderBy('created_at','DESC')
            ->get();

        return Response([
            'status' => 'success',
            'data' => $journal_entries,
            'message' => null,
        ], Response::HTTP_OK);
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
        //TODO: Zrobić walidacje

        $journal_entries = new JournalEntry;
        $journal_entries->internship_id = $request->input('internshipId');
        $journal_entries->content = $request->input('content');
        $journal_entries->user_id = auth()->id();
        $journal_entries->created_at = date('Y-m-d H:i:s');
        $journal_entries->updated_at = date('Y-m-d H:i:s');

        if($journal_entries->save())
            return Response([
                'status' => 'success',
                'data' => $journal_entries,
                'message' => null,
            ], Response::HTTP_OK);
        else
            return Response([
                'status' => 'error',
                'data' => null,
                'message' => "Przepraszamy, coś poszło nie tak!",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Confirm many internships
     *
     * @param Request $request
     * @return Response
     */
    public function confirmMany(Request $request)
    {
        $journalEntries = JournalEntry::whereIn('id', $request->input('array'))->get();
        $savedJournalEntries = array();

        foreach ($journalEntries as $journalEntry) {
            $journalEntry->accepted = 1;
            if($journalEntry->save())
                array_push($savedJournalEntries, $journalEntry->id);
        }

        return response([
            'status' => 'success',
            'data' => $savedJournalEntries,
            'message' => null
        ], Response::HTTP_OK);
    }
}

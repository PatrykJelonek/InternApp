<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(auth()->user()->hasRole(['user']))
        {
        $students = Student::all();

        if (isset($students))
            return response($students, Response::HTTP_OK);
        else
            return response("Students not found!", Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
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
        if(auth()->user()->hasRole(['user']))
        {
        //TODO: Napisać wiadomości zwrotne
        $validatedData = $request->validate([
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'phone' => 'required|max:16',
            'email' => 'required|unique:users|max:64',
            'password' => 'required|max:255',
            'index' => 'required|min:0|max:10',
            'year' => 'required|min:0|max:4',
            'semester' => 'required|min:0|max:8',
            'specializationId' => 'required',
            'universityId' => 'required'
        ]);

        $user = new User;
        $user->first_name = $request->input("firstName");
        $user->last_name = $request->input("lastName");
        $user->phone_number = $request->input("phone");
        $user->email = $request->input("email");
        $user->password_hash = Hash::make($request->input("password"));
        $user->password_reset_token  = Str::random(64);
        $user->remember_token = "remember_token";
        $user->user_status_id = 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            $student = new Student;
            $student->user_id = $user->id;
            $student->student_index = $request->input('index');
            $student->semester = $request->input('semester');
            $student->study_year = $request->input('year');
            $student->specialization_id = $request->input('specializationId');
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');

            if($student->save())
            {
                if($user->attachRole('student')) {
                    $user->universities()->attach($request->input('universityId'), ['created_at' => date('Y-m-d H:i:s')]);
                    return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => 'Konto zostało utworzone!'
                    ], Response::HTTP_OK);
                }
                $student->delete();
            }
            $user->delete();
        }

        return response([
            'status' => 'error',
            'data' => null,
            'message' => 'Nie udało się utworzyć konta!'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }else
    {
        return response([
                    'status' => 'error',
                    'data' => null,
                    'message' => "Nie masz uprawnień!"
                ], Response::HTTP_UNAUTHORIZED);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id)
    {
        if(auth()->user()->hasRole(['user']))
        {
        $student = Student::find($id);

        if (isset($student))
            return response($student, Response::HTTP_OK);
        else
            return response("Student not found!", Response::HTTP_NOT_FOUND);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function update(Request $request, Student $student)
    {
        //TODO: Create method to update student
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(auth()->user()->hasRole(['user']))
        {
        $student = Student::find($id);

        if ($student->delete())
            return response("Student has been deleted!", Response::HTTP_OK);
        else
            return response("Student has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }else
        {
            return response([
                        'status' => 'error',
                        'data' => null,
                        'message' => "Nie masz uprawnień!"
                    ], Response::HTTP_UNAUTHORIZED);
        }
    }
}

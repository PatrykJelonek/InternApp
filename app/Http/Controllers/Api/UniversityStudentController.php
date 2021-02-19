<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collections\StudentCollection;
use App\Http\Resources\Student as StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UniversityStudentController extends Controller
{
    /**
     * Students
     * Display a university students collection.
     *
     * @queryParam university_id required The id of university
     * @apiResourceCollection App\Http\Resources\Collections\StudentCollection
     * @apiResourceModel App\Student
     *
     * @response 404 {
     *  "message": "Not found students at this university!"
     * }
     *
     * @param $university_id
     * @return JsonResponse
     */
    public function index($university_id)
    {
        if(!$this->ownStudents($university_id) OR !Auth::user()->hasPermission('view-university-students'))
            abort(403);

        $students = Student::whereIn('user_id', function ($query) use ($university_id) {
            $query->select('user_id')
                ->from('users_universities')
                ->where('university_id', $university_id);
        })->get();

        return response()->json(new StudentCollection($students));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        if(!Auth::user()->hasPermission('view-university-student'))
            abort(403);

        return response()->json(new StudentResource(Student::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Checks whether the user belongs to the same university as the student
     * @param $university_id
     * @return bool
     */
    private function ownStudents($university_id)
    {
        if(Auth::id() && !Auth::guest())
        {
            if(DB::table('users_universities')->where(['user_id' => Auth::id(), 'university_id' => $university_id])->count() > 0)
                return true;
        }

        return false;
    }
}

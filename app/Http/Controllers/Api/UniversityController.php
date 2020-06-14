<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
use App\Agreement;
use App\Http\Api\Controllers\Controller;
use App\Role;
use App\University;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $universities = University::all();

        if (isset($universities))
            return response([
                'status' => 'success',
                'data' => $universities,
                'message' => null
            ], Response::HTTP_OK);
        else
            return \response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie znaleziono żadnego uniwersytetu!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Return specific university faculties
     *
     * @param $id
     * @return Response
     */
    public function universityFaculties($id)
    {
        $universities = University::find($id);

        if (isset($universities->faculties))
            return response([
                'status' => 'success',
                'data' => $universities->faculties,
                'message' => null
            ], Response::HTTP_OK);
        else
            return \response([
                'status' => 'error',
                'data' => null,
                'message' => 'Nie znaleziono żadnego uniwersytetu!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            'name' => 'required|unique:universities|max:255',
            'universityTypeId' => 'required',
            'cityId' => 'required',
            'street' => 'required|max:64',
            'streetNumber' => 'required|max:8',
            'email' => 'required|max:64',
            'phone' => 'required|max:16',
            'website' => 'required|max:64',
        ], University::messages());

        $university = new University;

        $university->name = $request->input('name');
        $university->university_type_id = $request->input('universityTypeId');
        $university->city_id = $request->input('cityId');
        $university->street = $request->input('street');
        $university->street_number = $request->input('streetNumber');
        $university->email = $request->input('email');
        $university->phone = $request->input('phone');
        $university->website = $request->input('website');
        $university->access_code = $this->generateUniqueRandomAccessCode();
        $university->created_at = date('Y-m-d H:i:s');
        $university->updated_at = date('Y-m-d H:i:s');

        if($university->save())
        {
            if($university->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')]))
                return response([
                    'status' => 'success',
                    'data' => null,
                    'message' => 'Uczelnia została dodana!'
                ], Response::HTTP_OK);
        } else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => 'Niestety nie udało się dodać twojej uczelni!'
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
        $university = University::find($id);

        if (isset($university))
            return response($university, Response::HTTP_OK);
        else
            return reponse("University not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param University $university
     * @return Response
     */
    public function edit(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param University $university
     * @return Response
     */
    public function update(Request $request, University $university)
    {
        //TODO: Create method to update University
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $university = University::find($id);

        if ($university->delete())
            return response("University has been deleted!", Response::HTTP_OK);
        else
            return response("University has not been deleted", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Set new access code for university.
     *
     * @param Request $request
     * @return Response
     */
    public function setNewAccessCode(Request $request)
    {
        //TODO: Będzie trzeba to zabezpieczyć

        $university = University::find($request->input("id"));

        if(isset($university))
        {
            $university->access_code = $this->generateUniqueRandomAccessCode();

            if($university->save())
                return response([
                    'status' => 'success',
                    'data' => $university->access_code,
                    'message' => null,
                ], Response::HTTP_OK);
        }

        return response([
            'status' => 'error',
            'data' => null,
            'message' => 'New access code has been not generate!',
        ], Response::HTTP_NOT_MODIFIED);
    }

    /**
     * Use access code to join to university
     *
     * @param Request $request
     * @return Response
     */
    public function useCode(Request $request)
    {
        $university = University::where('access_code', $request->input('accessCode'))->first();
        $errorMessage = "Coś poszło nie tak!";

        if($university === null)
            $errorMessage  = "Nie udało się dopasować podanego kodu do żadnej uczelni!";
        else
            if((count($university->users()->where('user_id', auth()->id())->get()) < 1))
            {
                if($university->users()->save(auth()->user(), ['created_at' => date('Y-m-d H:i:s')]))
                    return response([
                        'status' => 'success',
                        'data' => $university,
                        'message' => null
                    ], Response::HTTP_OK);
                else
                    $errorMessage = "Nie udało się dodać Cię do tej uczelni!";
            } else
                $errorMessage  = 'Należysz już do uczelni do której przypisano podany kod!';

        return response([
            'status' => 'error',
            'data' => null,
            'message' => $errorMessage
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Use access code to join to university
     *
     * @param $id
     * @return Response
     */
    public function getUsers($id) {
        $university = University::find($id);

        if(isset($university))
            return response([
                'status' => 'success',
                'data' => $university->users,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie udało się znaleźć użytkowników tej uczelni"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Return university agreements
     *
     * @param $id
     * @return Response
     */
    public function getUniversityAgreements($id) {
        $university = Agreement::with(['offer', 'company'])->where(['university_id' => $id])->get();

        if(isset($university))
            return response([
                'status' => 'success',
                'data' => $university,
                'message' => null
            ], Response::HTTP_OK);
        else
            return response([
                'status' => 'error',
                'data' => null,
                'message' => "Nie udało się żadnych umów dla tej uczelni!"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Generate unique random access code.
     *
     * @return string
     */
    private function generateUniqueRandomAccessCode()
    {
        do {
            $randomAccessCode = Str::upper( Str::random(8));
        } while(count(University::where('access_code', $randomAccessCode)->get()) > 0);

        return $randomAccessCode;
    }
}

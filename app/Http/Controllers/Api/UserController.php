<?php

namespace App\Http\Controllers\Api;

use App\Constants\InternshipStatusConstants;
use App\Constants\UserStatusConstants;
use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserActivateUserRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Requests\UserShowRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateAvatarRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdatePersonalDataRequest;
use App\Http\Resources\Collections\InternshipCollection;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserService    $userService
     */
    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allUsers = User::all();

        if (isset($allUsers)) {
            return response($allUsers, Response::HTTP_OK);
        } else {
            return response("Error", Response::HTTP_NOT_FOUND);
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
     * @param UserStoreRequest $request
     *
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->userService->createUser(
            $request->input("email"),
            $request->input("password"),
            $request->input("firstName"),
            $request->input("lastName"),
            $request->input("phone"),
            $this->userRepository->getUserStatusByName(UserStatusConstants::USER_STATUS_INACTIVE)->id
        );

        if (!is_null($user)) {
            $user->attachRole('user');
            UserCreated::dispatch($user);
            return response($user, Response::HTTP_CREATED);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param UserShowRequest $request
     * @param int             $id
     *
     * @return Response
     */
    public function show(UserShowRequest $request, int $id): Response
    {
        $user = $this->userRepository->getUserById($id);

        if ($user !== null) {
            return response($user, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }


    public function resetPassword(UserResetPasswordRequest $request)
    {
        $user = User::where(['password_reset_token' => $request->input('token')])->first();

        $user->password_hash = Hash::make($request->input('password'));
        $user->password_reset_token = Str::uuid();

        if ($user->update()) {
            return response(null, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        $user = User::find(Auth::id());

        $user->password_hash = Hash::make($request->input('newPassword'));

        if ($user->update()) {
            return response(null, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updatePersonalData(UserUpdatePersonalDataRequest $request)
    {
        $user = User::find(Auth::id());

        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->phone = $request->input('phone');

        if ($user->update()) {
            return response(null, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updateAvatar(UserUpdateAvatarRequest $request)
    {
        $path = $request->file('avatar')->store('avatars');

        if (!empty($path)) {
            $user = User::find(Auth::id());
            $oldAvatarPath = $user->avatar_url;

            $user->avatar_url = $path;

            if ($user->update()) {
                Storage::delete($oldAvatarPath);
                return response($path, Response::HTTP_OK);
            }
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getInternships()
    {
        $user = User::with('student.internships.offer')->where(["id" => auth()->id()])->first();

        return Response(
            [
                'status' => 'success',
                'data' => $user->student->internships,
                'message' => null,
            ],
            Response::HTTP_OK
        );
    }

    public function getJournals()
    {
        $user = User::with('journals')->where(["id" => auth()->id()])->first();

        return Response(
            [
                'status' => 'success',
                'data' => $user->journals,
                'message' => null,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Get user interns
     *
     * @return Response
     */
    public function getCompaniesInterns()
    {
        $user = User::with('companySupervisorInternships.student')->where(["id" => auth()->id()])->distinct()->first();

        return Response(
            [
                'status' => 'success',
                'data' => $user->companySupervisorInternships,
                'message' => null,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @param string|null $status
     *
     * @return Response
     */
    public function getUserInternships(string $status = null): Response
    {
        $internships = $this->userRepository->getInternships(Auth::user()->id, [$status]);

        if (!is_null($internships)) {
            return response($internships, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function activateUser(UserActivateUserRequest $request, string $activationToken)
    {
        $result = $this->userService->changeUserStatus(
            $this->userRepository->getUserByActivationToken($activationToken)->id,
            $this->userRepository->getUserStatusByName(UserStatusConstants::USER_STATUS_ACTIVE)->id
        );

        if ($result) {
            return response(null, Response::HTTP_OK);
        }

        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

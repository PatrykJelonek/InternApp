<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserMessageIndexRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserMessageController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserMessageController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserMessageIndexRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function index(UserMessageIndexRequest $request)
    {
        $userMessages = $this->userRepository->getMessages(Auth::id());

        return response($userMessages, Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Events\MessageSent;
use App\Events\Test;
use App\Models\User;
use App\Notifications\MessageSentNotification;
use Illuminate\Http\Request;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function test() {
        Auth::user()->notify(new MessageSentNotification());
    }

    public function testPost(Request $request) {
        broadcast(new MessageSent($request->message));
        return "Event has been sent!";
    }
}

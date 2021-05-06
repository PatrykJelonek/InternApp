<?php

namespace App\Http\Controllers\api;

use App\Events\MessageSent;
use App\Models\Offer;
use App\Models\User;
use App\Repositories\StudentRepository;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        broadcast(new MessageSent(User::find(Auth::id())));
    }
}

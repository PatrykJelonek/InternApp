<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * TaskController constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository, TaskService $taskService)
    {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $internshipId
     * @return \Illuminate\Http\Response
     */
    public function index(int $internshipId)
    {
        return response($this->taskRepository->getByInternship($internshipId), Response::HTTP_OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Todo
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        $task = $this->taskRepository->one($taskId);

        if(!$this->taskService->isAuthor($task, Auth::user())) {
            abort(403);
        }

        return response(new TaskResource($task), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task->delete())
            return response("Task has been deleted!", Response::HTTP_OK);
        else
            return response("Task has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

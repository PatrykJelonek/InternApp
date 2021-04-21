<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepository;
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
     * TaskController constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $internshipId
     * @return Response
     */
    public function index(int $internshipId)
    {
        return response($this->taskRepository->getByInternship($internshipId), Response::HTTP_OK);
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
     * @param int $internshipId
     * @param int $studentId
     * @param StoreTaskRequest $request
     * @return Response
     */
    public function store(int $internshipId, int $studentId = null, StoreTaskRequest $request): Response
    {
        $validated = $request->validated();

        if($validated) {
            $result = $this->taskRepository->create($request->all(), $internshipId, $studentId);

            if(!empty($result)) {
                return response(new TaskResource($result), Response::HTTP_CREATED);
            }
        }

        return response(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
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
     * @param Request $request
     * @param  \App\Task  $task
     * @return Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return Response
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

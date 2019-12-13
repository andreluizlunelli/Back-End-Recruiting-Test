<?php

namespace App\Http\Controllers;

use App\Services\NewTaskService;
use App\Services\TaskSearchService;
use App\Services\TemporaryGuestService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * @var TaskSearchService
     */
    private $searchTasks;

    /**
     * @var TemporaryGuestService
     */
    private $guest;

    /**
     * @var NewTaskService
     */
    private $newTask;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * TaskController constructor.
     * @param TaskSearchService $search
     * @param TemporaryGuestService $guest
     * @param NewTaskService $newTask
     */
    public function __construct(TaskSearchService $search, TemporaryGuestService $guest, NewTaskService $newTask)
    {
        $this->searchTasks = $search;
        $this->guest = $guest;
        $this->newTask = $newTask;
        $this->user = $guest->get();
    }

    public function listTasks(Request $request)
    {
        $args = [
            'limit' => $request->get('limit', 15),
            'page' => $request->get('page', 1),
            'type' => $request->get('type'),
            'done' => $request->get('done'),
            'like' => $request->get('like'),
        ];

        $result = $this->searchTasks->search($this->user, $args);

        if ($result->isNotEmpty())
            return response()->json($result);

        return $this->emptyMessage();

    }

    protected function emptyMessage()
    {
        $message = [
            'message' => 'Wow. You have nothing else to do. Enjoy the rest of your day!'
        ];

        return response()->json($message, Response::HTTP_NOT_FOUND, $message);
    }

    public function find(Request $request)
    {
        try {
            $idOrUuid = $request->route()->parameter('idOrUuid');

            return $this->searchTasks->get($this->user, $idOrUuid)->front();

        } catch (\Throwable $t) {

            $message = [
                'message' => $t->getMessage()
            ];

            return response()->json($message, Response::HTTP_NOT_FOUND, $message);
        }
    }

    public function new(Request $request)
    {
        try {
            $task = $this->newTask->new($this->user, $request);

            $headers = [
                'location' => route('findTask', ['idOrUuid' => $task->id])
            ];

            return response()->json($task->front(), Response::HTTP_CREATED, $headers);

        } catch (\Throwable $t) {

            $message = [
                'message' => $t->getMessage()
            ];

            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

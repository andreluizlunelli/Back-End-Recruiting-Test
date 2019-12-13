<?php

namespace App\Services;

use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewTaskService
{
    /**
     * @var ValidateNewTaskInputsService
     */
    private $validate;

    /**
     * NewTaskService constructor.
     * @param ValidateNewTaskInputsService $validate
     */
    public function __construct(ValidateNewTaskInputsService $validate)
    {
        $this->validate = $validate;
    }

    public function new(User $user, Request $inputs): Task
    {
        $dataInputs = $inputs->all();

        $this->validate->validate($dataInputs);

        $task = new Task();
        $task->user_id = $user->id;
        $task->uuid = Str::uuid();
        $task->type = Task::valueSwitch($dataInputs['type']);
        $task->title = $dataInputs['title'];
        $task->description = $dataInputs['description'] ?? null;
        $task->priority = $dataInputs['priority'] ?? null;

        $task->save();

        return $task;
    }

}

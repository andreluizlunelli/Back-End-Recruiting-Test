<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class UpdateTaskService
{
    use TypeToLowerCaseTrait;

    public function update(Task $task, Request $request): Task
    {
        $dataInputs = $this->changeTypeToLowerCase($request->all());

        if (array_key_exists('title', $dataInputs) && ! empty($dataInputs['title'])) {
            $task->title = $dataInputs['title'];
        }

        if (array_key_exists('description', $dataInputs)) {
            $task->description = $dataInputs['description'];
        }

        if (array_key_exists('type', $dataInputs)) {
            $task->type = Task::valueSwitch($dataInputs['type']);
        }

        if (array_key_exists('done', $dataInputs)) {
            $task->done = $dataInputs['done'];
        }

        if (array_key_exists('priority', $dataInputs)) {
            $task->priority = $dataInputs['priority'];
        }

        $task->update();

        return $task;
    }

}

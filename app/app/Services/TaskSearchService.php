<?php

namespace App\Services;

use App\Http\Controllers\NotFoundException;
use App\Models\Task;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TaskSearchService
{

    /**
     * @param User $user
     * @param array $args [page, limit, type, done, like, sort_order]
     *
     * @return array
     */
    public function search(User $user, array $args): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = Task::where('user_id', $user->id);

        $page = (int) isset($args['page']) ? $args['page'] : 1;

        $limit = (int) isset($args['limit']) ? $args['limit'] : 15;

        $this->filter($builder, $args);

        $sortOrder = $args['sort_order'] == 0
            ? 'desc'
            : 'asc';

        $builder->orderBy('priority', $sortOrder);

        $result = $builder->paginate($limit, ['*'], $pageName = 'page', $page);

        $result->transform(function (Task $task) {
            return $task->front();
        });

        return $result;
    }

    private function filter(Builder $builder, array $args): void
    {
        if ( ! is_null($args['type'] ?? null)) {
            $type = Task::valueSwitch($args['type']);

            $builder->where('type', $type);
        }

        if ( ! is_null($args['done'] ?? null)) {
            $done = (bool) isset($args['done']) ? $args['done'] : null;

            $builder->where('done', $done);
        }

        if ( ! is_null($args['like'] ?? null)) {
            $like = "%{$args['like']}%";

            $builder->where('title', 'like', $like)
                ->orWhere('description', 'like', $like);
        }
    }

    public function get(User $user, $idOrUuid): Task
    {
        $builder = is_numeric($idOrUuid)
            ? Task::where('id', $idOrUuid)
            : Task::where('uuid', $idOrUuid);

        $task = $builder->where('user_id', $user->id)->first();

        if (empty($task))
            throw new NotFoundException('Wow. Nothing here.');

        return $task;
    }

}

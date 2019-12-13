<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const TYPE_TASK_WORK = 1;
    const TYPE_TASK_SHOPPING = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'uuid',
        'type',
        'done',
        'priority',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function valueSwitch($type)
    {
        if (is_numeric($type)) {
            switch ($type) {
                case self::TYPE_TASK_SHOPPING: return 'shopping'; break;
                case self::TYPE_TASK_WORK: return 'work'; break;
                default:
                    throw new \InvalidArgumentException('Wow. For now only: 1 and 2 are valid parameters, sorry');
            }
        }

        switch ($type) {
            case 'shopping': return self::TYPE_TASK_SHOPPING; break;
            case 'work': return self::TYPE_TASK_WORK; break;
            default:
                throw new \InvalidArgumentException('Wow. For now only: shopping and work are valid parameters, sorry');
        }
    }

    public function front(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'uuid' => $this->uuid,
            'type' => self::valueSwitch($this->type),
            'done' => (bool) $this->done,
            'priority' => $this->priority,
            'date_created' => $this->created_at
        ];
    }

}

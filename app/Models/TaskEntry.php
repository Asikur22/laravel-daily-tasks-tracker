<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskEntry extends Model
{
    protected $fillable = ['task_id', 'date', 'status'];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}

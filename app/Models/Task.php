<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id', 'task_group_id', 'title', 'description', 'deadline', 'priority', 'completed_at'];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];
    public function group()
    {
        return $this->belongsTo(TaskGroup::class, 'task_group_id');
    }
}
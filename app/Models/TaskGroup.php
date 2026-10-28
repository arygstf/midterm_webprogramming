<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

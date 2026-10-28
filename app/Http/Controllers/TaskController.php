<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $groups = $user->groups;
        $groupId = $request->query('group');
        $dir = $request->query('sort') === 'desc' ? 'desc' : 'asc';

        $tasks = $user->tasks()
            ->when($groupId, fn ($q) => $q->where('task_group_id', $groupId))
            ->whereNull('completed_at')
            ->orderByRaw('deadline is null, deadline ' . $dir)
            ->get();

        $previous = $user->tasks()
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->get();

        return view('tasks.index', compact('groups', 'groupId', 'tasks', 'previous'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'in:low,medium,high',
            'task_group_id' => 'nullable|exists:task_groups,id',
        ]);

        $request->user()->tasks()->create($data);

        return back();
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 403);

        $task->update($request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'sometimes|in:low,medium,high',
        ]));

        return back();
    }

    public function toggle(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 403);

        $task->update(['completed_at' => $task->completed_at ? null : now()]);

        return back();
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 403);

        $task->delete();

        return back();
    }
}
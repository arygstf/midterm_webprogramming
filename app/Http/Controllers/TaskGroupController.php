<?php

namespace App\Http\Controllers;

use App\Models\TaskGroup;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $request->user()->groups()->create($data);

        return back();
    }

    public function destroy(Request $request, TaskGroup $group)
    {
        abort_unless($group->user_id === $request->user()->id, 403);

        $group->delete();

        return redirect()->route('tasks.index');
    }
}
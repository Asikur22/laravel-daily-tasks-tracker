<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'notification_time' => 'nullable|date_format:H:i',
            'recurring_days' => 'nullable|array',
            'recurring_days.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
        ]);

        $request->user()->tasks()->create($validated);

        return back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        // Ensure user owns task
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'notification_time' => 'nullable|date_format:H:i',
            'recurring_days' => 'nullable|array',
            'recurring_days.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }

        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }
}

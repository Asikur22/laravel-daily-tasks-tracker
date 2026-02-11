<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');
        $dayOfWeek = strtolower(now()->format('D')); // mon, tue, etc.
        $user = auth()->user();

        // Get all tasks for the user
        $tasks = $user->tasks()->with(['category', 'entries' => function ($query) use ($today) {
            $query->where('date', $today);
        }])->get()->filter(function ($task) use ($dayOfWeek) {
            // Filter by recurring days
            if (is_null($task->recurring_days)) {
                return true; 
            }
            // If recurring_days is stored as JSON, get decoding is handled by model casting
            return in_array($dayOfWeek, $task->recurring_days);
        });

        $categories = $user->categories;
        
        // Calculate completion percentage
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->filter(function($task) {
            $entry = $task->entries->first();
            return $entry && $entry->status === 'complete';
        })->count();
        
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return view('dashboard', compact('tasks', 'categories', 'today', 'completionPercentage'));
    }
}

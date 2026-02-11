<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        
        $startOfMonth = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        
        $user = auth()->user();
        $tasks = $user->tasks; // Get all tasks
        
        // Eager load entries for this month
        $entries = \App\Models\TaskEntry::whereHas('task', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereBetween('date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
        ->get();
        
        $calendar = [];
        $current = $startOfMonth->copy();
        
        while ($current <= $endOfMonth) {
            $dateStr = $current->format('Y-m-d');
            $dayOfWeek = strtolower($current->format('D'));
            
            // Expected tasks for this day
            $expectedTasks = $tasks->filter(function($task) use ($dayOfWeek) {
                 if (is_null($task->recurring_days)) return true;
                 return in_array($dayOfWeek, $task->recurring_days);
            });
            
            $countExpected = $expectedTasks->count();
            
            // Actual stats
            $dayEntries = $entries->where('date', $dateStr);
            $countCompleted = $dayEntries->where('status', 'complete')->count();
            $countExempt = $dayEntries->where('status', 'exempt')->count();
            
            // Adjust denominator for exempt tasks? 
            // Percentage = Completed / (Expected - Exempt) ?
            // Or just raw completion. Let's do (Completed / Expected) * 100 for simplicity, 
            // handling exempt as "removed from denominator" or "completed".
            // Prompt says "exempt". Usually means doesn't count against you.
            
            $effectiveTotal = $countExpected - $countExempt;
            if ($effectiveTotal < 0) $effectiveTotal = 0; // Should not happen unless data inconsistency
            
            $percentage = 0;
            if ($effectiveTotal > 0) {
                $percentage = round(($countCompleted / $effectiveTotal) * 100);
            } elseif ($countExpected > 0 && $countExempt == $countExpected) {
                 $percentage = 100; // All exempt
            }
            
            $calendar[] = [
                'date' => $current->copy(),
                'day' => $current->day,
                'percentage' => $percentage,
                'total' => $countExpected,
                'completed' => $countCompleted,
                'is_future' => $current->isFuture(),
            ];
            
            $current->addDay();
        }
        
        return view('history', compact('calendar', 'year', 'month', 'startOfMonth'));
    }
}

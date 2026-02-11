<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskEntry;
use Illuminate\Http\Request;

class TaskEntryController extends Controller
{
    public function toggle(Task $task)
    {
        $today = now()->format('Y-m-d');
        
        $entry = $task->entries()->where('date', $today)->first();

        if (!$entry) {
            // blank -> complete
            $entry = $task->entries()->create([
                'date' => $today,
                'status' => 'complete'
            ]);
        } else {
            if ($entry->status === 'complete') {
                // complete -> incomplete
                $entry->update(['status' => 'incomplete']);
            } elseif ($entry->status === 'incomplete') {
                // incomplete -> exempt
                $entry->update(['status' => 'exempt']);
            } else {
                // exempt -> blank (delete)
                $entry->delete();
                return response()->json(['status' => 'blank']);
            }
        }

        return response()->json(['status' => $entry->status]);
    }
}

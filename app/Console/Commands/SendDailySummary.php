<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily summary email to all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::all();
        $dateStr = now()->format('Y-m-d');
        $dayOfWeek = strtolower(now()->format('D'));

        foreach ($users as $user) {
            // Find tasks relevant for today
            $tasks = $user->tasks;
            $expectedTasks = $tasks->filter(function($task) use ($dayOfWeek) {
                 if (is_null($task->recurring_days)) return true;
                 return in_array($dayOfWeek, $task->recurring_days);
            });
            
            $countExpected = $expectedTasks->count();
            
            // Get entries for today
            $entries = \App\Models\TaskEntry::whereHas('task', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('date', $dateStr)
            ->get();
            
            $countCompleted = $entries->where('status', 'complete')->count();
            $countExempt = $entries->where('status', 'exempt')->count();
            
            $effectiveTotal = $countExpected - $countExempt;
            if ($effectiveTotal < 0) $effectiveTotal = 0; 
            
            $percentage = 0;
            if ($effectiveTotal > 0) {
                $percentage = round(($countCompleted / $effectiveTotal) * 100);
            } elseif ($countExpected > 0 && $countExempt == $countExpected) {
                 $percentage = 100; // All exempt
            }

            // Only send if there were tasks expected or some activity
            if ($countExpected > 0) {
                $data = [
                    'name' => $user->name,
                    'date' => now()->format('l, F j, Y'),
                    'total' => $countExpected,
                    'completed' => $countCompleted,
                    'exempt' => $countExempt,
                    'percentage' => $percentage,
                ];

                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\DailySummary($data));
                $this->info("Sent summary to {$user->email}");
            }
        }
    }
}

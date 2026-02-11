<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        $user = \App\Models\User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $work = \App\Models\Category::create(['name' => 'Work', 'color' => '#3b82f6', 'user_id' => $user->id]);
        $personal = \App\Models\Category::create(['name' => 'Personal', 'color' => '#10b981', 'user_id' => $user->id]);
        $health = \App\Models\Category::create(['name' => 'Health', 'color' => '#ef4444', 'user_id' => $user->id]);
        $learning = \App\Models\Category::create(['name' => 'Learning', 'color' => '#f59e0b', 'user_id' => $user->id]);

        // Tasks
        \App\Models\Task::create([
            'title' => 'Morning Standup', 
            'category_id' => $work->id, 
            'notification_time' => '09:00', 
            'recurring_days' => ['mon', 'tue', 'wed', 'thu', 'fri'], 
            'user_id' => $user->id
        ]);

        \App\Models\Task::create([
            'title' => 'Gym Workout', 
            'category_id' => $health->id, 
            'notification_time' => '18:00', 
            'recurring_days' => ['mon', 'wed', 'fri'], 
            'user_id' => $user->id
        ]);

        \App\Models\Task::create([
            'title' => 'Read 30 Minutes', 
            'category_id' => $learning->id, 
            'notification_time' => '21:00', 
            'recurring_days' => null, // Every day
            'user_id' => $user->id
        ]);
        
        \App\Models\Task::create([
            'title' => 'Grocery Shopping', 
            'category_id' => $personal->id, 
            'notification_time' => '10:00', 
            'recurring_days' => ['sat'], 
            'user_id' => $user->id
        ]);
    }
}

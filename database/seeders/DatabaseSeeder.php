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
            'name' => 'Asiqur Rahman',
            'email' => 'asikur22@gmail.com',
            'password' => bcrypt('=hvGCx6/}_DaXE8TVrbr'),
        ]);

        // Categories
        $personal = \App\Models\Category::create(['name' => 'Personal', 'color' => '#1DDDD9', 'user_id' => $user->id]);
        $work = \App\Models\Category::create(['name' => 'Work', 'color' => '#3b82f6', 'user_id' => $user->id]);
        $health = \App\Models\Category::create(['name' => 'Health', 'color' => '#ef4444', 'user_id' => $user->id]);
        $learning = \App\Models\Category::create(['name' => 'Learning', 'color' => '#f59e0b', 'user_id' => $user->id]);
        $religious = \App\Models\Category::create(['name' => 'Religious', 'color' => '#10b981', 'user_id' => $user->id]);

        // Tasks
        \App\Models\Task::create([
            'title' => 'Walk 30 Minutes', 
            'category_id' => $health->id, 
            'notification_time' => '18:00', 
            'recurring_days' => null, 
            'user_id' => $user->id
        ]);

        \App\Models\Task::create([
            'title' => 'Read 30 Minutes', 
            'category_id' => $learning->id, 
            'notification_time' => '21:00', 
            'recurring_days' => null, // Every day
            'user_id' => $user->id
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;


class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->create([
            'user_id' => 1,
            'title' => 'Buy Groceries',
            'description' => 'Milk, Bread, Cheese',
            'start_at' => now(),
            'end_at' => now()->addHour()
        ]);
    }
}

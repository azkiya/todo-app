<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks(): void
    {
        $response = $this->get('/api/tasks');
        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => true,
            'data' => true,
        ]);
    }

    public function test_can_get_single_tasks_by_id(): void
    {
        // Create a single task
        $task = Task::factory()->create();

        // Send GET request to the /api/tasks/{id} endpoint
        $response = $this->get('/api/tasks/' . $task->id);

        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => true,
            'data' => true,
        ]);
    }
}

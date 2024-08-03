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
        $response->dd();
        $response
        ->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => true,
            'data' => true,
        ]);
    }

    public function test_can_search_task_by_status()
    {
        $task = Task::factory()->create(['status' => 2]);

        $response = $this->getJson('/api/tasks?status=2');

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => '2']);
        $response->assertJsonMissing(['status' => '1']);
    }

    public function test_can_search_task_by_start_end_at()
    {
        $task = Task::factory()->create([
            'start_at' => "2024-08-01 01:00:00",
            'end_at' => "2024-08-01 02:00:00",
        ]);

        $response = $this->getJson('/api/tasks?start_at=2024-08-01 01:00:00&end_at=2024-08-01 02:00:00');

        $response->assertStatus(200);
        $response->assertJsonFragment(['start_at' => "2024-08-01 01:00:00"]);
        $response->assertJsonMissing(['start_at' => "2024-08-01 11:00:00"]);
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

    public function test_get_single_post_not_found()
    {
        // Send GET request to the /api/tasks/{id} endpoint with a non-existing ID
        $response = $this->get('/api/tasks/999');

        // Assert the status is 404
        $response->assertStatus(404);

        // Assert the response structure
        $response->assertJson([
            'message' => 'Task not found',
        ]);
    }
    public function test_can_store_task()
    {
        // Prepare data
        $data = [
            'user_id' => 1,
            'title' => 'Test Todo List',
            'description' => 'This is the description of the test task.',
            'start_at' => now(),
            'end_at' => now()->addHour()
        ];

        // Send POST request to the /api/tasks endpoint
        $response = $this->postJson('/api/tasks', $data);

        // Assert the status is 201
        $response
        ->assertStatus(201)
        ->assertJson([
            'status' => true,
            'message' => true,
            'data' => true,
        ]);
        $this->assertDatabaseHas('tasks', [
            'user_id' => 1,
            'title' => 'Test Todo List',
            'description' => 'This is the description of the test task.']);
    }

    public function test_can_delete_post()
    {
        // Create a single task
        $task = Task::factory()->create();

        // Send DELETE request to the /api/tasks/{id} endpoint
        $response = $this->delete('/api/tasks/' . $task->id);

        // Assert the status is 200
        $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Task todo deleted successfully',
        ]);

       // Assert the data is soft deleted in the database
       $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}

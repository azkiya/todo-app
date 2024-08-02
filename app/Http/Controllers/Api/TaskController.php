<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->paginate(5);

        $data =  new TaskResource(200001, 'Task todo retrieved successfully', $tasks, true);

        return $data->toJson();
    }

    public function show($id)
    {
        $task = Task::find($id);

        $data = new TaskResource(200001, 'Task retrieved successfully', $task);

        return $data;
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);

        return new TaskResource(201001, 'Task todo created successfully', $task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return new TaskResource(200001, 'Task updated successfully', $task);
    }
}
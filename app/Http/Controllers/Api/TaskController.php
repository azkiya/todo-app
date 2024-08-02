<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->paginate(5);

        $data =  new TaskResource("200001", 'Task todo retrieved successfully', $tasks);

        return $data->toJson();
    }
}

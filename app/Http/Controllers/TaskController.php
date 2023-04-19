<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UserTask;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return response($tasks, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Response $response)
    {
        Log::info("Save Task");

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'due_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'remarks' => 'required|string|max:100',
            'status_id' => 'required|integer'
        ]);

        Log::info("Validate");

        if ($validator->fails()) {
            return response("Validation Failed");
        }

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status_id' => $request->status_id,
        ]);

        Log::info("Task");
        // save user tasks
        $user_task = UserTask::create([
            'user_id' => Auth::user()->id,
            'task_id' => $task->id,
            'due_date' => $request->due_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'remarks' => $request->remarks,
            'status_id' => $request->status_id,
        ]);

        Log::info("User Task");

        $response = [
            'task' => $task,
            'user_task' => $user_task
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

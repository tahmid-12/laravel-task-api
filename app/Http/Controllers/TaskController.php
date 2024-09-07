<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
    public function index()
    {
        $tasks = Auth::user()->tasks;  // Get tasks belonging to the authenticated user
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return response()->json($task, 201); // HTTP 201 Created
    }


    public function show($id)
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404); // HTTP 404 Not Found
        }

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

}

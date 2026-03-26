<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project', 'user']);

        // FILTERS
        if ($request->filter == 'my' && Auth::check()) {
            $query->where('assigned_to', Auth::id());
        }

        if ($request->filter == 'overdue') {
            $query->where('due_date', '<', Carbon::today())
                  ->where('status', '!=', 'completed');
        }


        if ($request->filter == 'completed') {
            $query->where('status', 'completed');
        }

        $tasks = $query->get();

        // ✅ IMPORTANT: ALWAYS LOAD THESE
        $projects = Project::all();
        $users = User::where('role', 'staff')->get();

        // AJAX RESPONSE
        if ($request->ajax()) {
            return response()->json($tasks);
        }

        return view('admin-tasks', compact('tasks', 'projects', 'users'));
    }

    public function store(Request $request)
    {
        Task::create([
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status ?? 'To Do',
            'due_date' => $request->due_date,
        ]);

        return redirect()->back()->with('success', 'Task created!');
    }
}
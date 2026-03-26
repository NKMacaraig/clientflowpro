<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{
    // LOAD PAGE
    public function index()
    {
        $projects = \App\Models\Project::with('client')->get();
        $clients = \App\Models\Client::all();
        $users = \App\Models\User::where('role', 'staff')->get();

        // ✅ ADD THESE (THIS FIXES YOUR ERROR)
        $healthy = \App\Models\Project::where('status', 'Completed')->count();
        $risk = \App\Models\Project::where('status', 'In Progress')->count();
        $critical = \App\Models\Project::where('status', 'Planning')->count();

        return view('admin-projects', compact(
            'projects',
            'clients',
            'users',
            'healthy',
            'risk',
            'critical'
        ));
    }

    // SAVE PROJECT
    public function store(Request $request)
    {
        $project = Project::create([
            'client_id' => $request->client_id,
            'project_name' => $request->project_name,
            'description' => $request->description, // <-- add this
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // attach users
        if ($request->users) {
            $users = explode(',', $request->users);
            $project->users()->attach($users);
        }

        return redirect()->route('projects.index');
    }
}
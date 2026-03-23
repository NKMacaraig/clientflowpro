<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;

class AdminController extends Controller
{
    public function dashboard()
    {
        // CARDS
        $totalClients = Client::count();
        $activeProjects = Project::where('status', 'active')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $monthlyRevenue = Invoice::whereMonth('invoice_date', now()->month)->sum('amount');

        // CHART 1: PROJECT STATUS COUNT
        $projectStatuses = Project::selectRaw('status, COUNT(*) as count')
                                ->groupBy('status')
                                ->pluck('count', 'status');

        // CHART 2: MONTHLY REVENUE
        $revenues = Invoice::selectRaw('MONTH(invoice_date) as month, SUM(amount) as total')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

        $months = [];
        $totals = [];

        foreach ($revenues as $rev) {
            $months[] = $rev->month;
            $totals[] = $rev->total;
        }

        $clients = Client::latest()->get();

        return view('admin-dashboard', compact(
            'totalClients',
            'activeProjects',
            'completedTasks',
            'monthlyRevenue',
            'clients',
            'projectStatuses',
            'months',
            'totals'
        ));

    }
    public function clients()
    {
        $clients = \App\Models\Client::latest()->get();
        return view('admin-clients', compact('clients'));
    }

    public function projects()
    {
        $projects = \App\Models\Project::with('client')->latest()->get();

        $healthy = \App\Models\Project::where('status', 'active')->count();
        $risk = \App\Models\Project::where('status', 'pending')->count();
        $critical = \App\Models\Project::where('status', 'delayed')->count();

        return view('admin-projects', compact('projects','healthy','risk','critical'));
    }

    public function tasks()
    {
        $tasks = \App\Models\Task::with('project')->latest()->get();
        return view('admin-tasks', compact('tasks'));
    }

    
    
}
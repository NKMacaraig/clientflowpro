@extends('admin')

@section('content')

<h2>Tasks</h2>
<p style="color:#6b7280;">Manage and track all your tasks</p>

<!-- FILTER BUTTONS -->
<div style="margin:15px 0;">
    <button class="btn">All Tasks</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">My Tasks</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">Overdue</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">Completed</button>
</div>

<div class="table-box">

<table>
    <thead>
        <tr>
            <th>TASK NAME</th>
            <th>PROJECT</th>
            <th>PRIORITY</th>
            <th>STATUS</th>
            <th>DUE DATE</th>
        </tr>
    </thead>

    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->task_name }}</td>
            <td>{{ $task->project->name ?? '' }}</td>

            <td>
                <span class="badge inactive">Medium</span>
            </td>

            <td>
                <span class="badge {{ $task->status == 'completed' ? 'active' : 'inactive' }}">
                    {{ ucfirst($task->status) }}
                </span>
            </td>

            <td>{{ $task->due_date ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection
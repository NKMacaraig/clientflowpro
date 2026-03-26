@extends('admin')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
    <div>
        <h2>Task</h2>
        <p style="color:#6b7280;">Manage and track all your tasks</p>
    </div>

    <button class="btn" onclick="openTaskModal()">+ Add Task</button>
</div>

<!-- ================= ADD TASK MODAL ================= -->
<div id="taskModal" class="modal">
    <div class="modal-card">

        <div class="modal-header">
            <h2>Create Task</h2>
            <span class="close" onclick="closeTaskModal()">×</span>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <!-- TASK NAME -->
            <label>Task Name</label>
            <input type="text" name="task_name" placeholder="Task Name" required>

            <!-- PROJECT SEARCH -->
            <label>Project</label>
            <input type="text" id="projectSearch" readonly onclick="openProjectDropdown()">
            <div id="projectDropdown" class="dropdown"></div>
            @error('project_id')
                <p style="color:red;">Please select a project from the list</p>
            @enderror
            <input type="hidden" name="project_id" id="projectId">

            <!-- DUE DATE -->
            <label>Due Date</label>
            <input type="date" name="due_date">

            <!-- ASSIGN STAFF -->
            <label>Assign Staff</label>
            <input type="text" id="staffSearch" placeholder="Search staff name...">
            <div id="staffDropdown" class="dropdown"></div>
            <input type="hidden" name="assigned_to" id="assignedTo">

            <!-- DESCRIPTION -->
            <label>Description</label>
            <textarea name="description" rows="3"></textarea>

            <!-- STATUS -->
            <label>Status</label>
            <select name="status">
                <option value="To Do">To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="Review">Review</option>
                <option value="Completed">Completed</option>
            </select>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeTaskModal()">Cancel</button>
                <button type="submit" class="btn-submit">Create Task</button>
            </div>

        </form>
    </div>
</div>

<!-- FILTER BUTTONS -->
<div style="margin:15px 0;">
    <button class="btn filter-btn active" data-filter="">All Tasks</button>
    <button class="btn filter-btn" data-filter="my">My Tasks</button>
    <button class="btn filter-btn" data-filter="overdue">Overdue</button>
    <button class="btn filter-btn" data-filter="completed">Completed</button>
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

    <tbody id="taskTableBody">
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->task_name }}</td>
            <td>{{ $task->project->name ?? '' }}</td>
            <td><span class="badge inactive">Medium</span></td>
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

<script>
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function () {

        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        let filter = this.getAttribute('data-filter');

        fetch(`{{ route('admin-tasks') }}?filter=${filter}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {

            let tableBody = document.getElementById('taskTableBody');
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="7">No tasks found</td></tr>`;
                return;
            }

            data.forEach(task => {

                // ✅ STATUS COLOR
                let statusClass = {
                    'completed': 'status-completed',
                    'in progress': 'status-progress',
                    'to do': 'status-todo',
                    'review': 'status-review'
                }[task.status?.toLowerCase()] || 'status-default';

                // ✅ PRIORITY COLOR (you can add column later)
                let priorityClass = 'priority-medium'; // default for now

                // ✅ USER INITIALS
                let userName = task.user ? task.user.name : 'N/A';
                let initials = userName.split(' ').map(n => n[0]).join('').toUpperCase();

                // ✅ FORMAT DATE
                let dueDate = task.due_date 
                    ? new Date(task.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) 
                    : '-';

                let row = `
                <tr>
                    <td>${task.task_name}</td>

                    <td>${task.project ? task.project.name : '-'}</td>

                    <td>
                        <div class="assigned-user">
                            <div class="avatar">${initials}</div>
                            <span>${userName}</span>
                        </div>
                    </td>

                    <td>
                        <span class="badge ${priorityClass}">Medium</span>
                    </td>

                    <td>
                        <span class="badge ${statusClass}">
                            ${task.status}
                        </span>
                    </td>

                    <td>${dueDate}</td>

                    <td>
                        <button class="action-btn">👁</button>
                    </td>
                </tr>
                `;

                tableBody.innerHTML += row;
            });
        });
    });
});
</script>

<script>

let projects = @json($projects);
let users = @json($users);

// OPEN / CLOSE
function openTaskModal() {
    document.getElementById("taskModal").style.display = "block";
}
function closeTaskModal() {
    document.getElementById("taskModal").style.display = "none";
}

//  PROJECT SEARCH 
document.getElementById("projectSearch").addEventListener("keyup", function() {

    let input = this.value.toLowerCase();
    let dropdown = document.getElementById("projectDropdown");

    dropdown.innerHTML = "";

    // ❗ RESET project_id when typing
    document.getElementById("projectId").value = "";

    if (!input) return;

    let filtered = projects.filter(p => 
        p.project_name.toLowerCase().startsWith(input)
    );

    filtered.forEach(project => {
        let div = document.createElement("div");
        div.innerText = project.project_name;

        div.onclick = () => {
            document.getElementById("projectSearch").value = project.project_name;
            document.getElementById("projectId").value = project.id;
            dropdown.innerHTML = "";
        };

        dropdown.appendChild(div);
    });
});

//  STAFF SEARCH 
document.getElementById("staffSearch").addEventListener("keyup", function() {

    let input = this.value.toLowerCase();
    let dropdown = document.getElementById("staffDropdown");

    dropdown.innerHTML = "";

    if (!input) return;

    let filtered = users.filter(u => 
        u.name.toLowerCase().startsWith(input)
    );

    filtered.forEach(user => {
        let div = document.createElement("div");
        div.innerText = user.name;

        div.onclick = () => {
            document.getElementById("staffSearch").value = user.name;
            document.getElementById("assignedTo").value = user.id;
            dropdown.innerHTML = "";
        };

        dropdown.appendChild(div);
    });
});

</script>

@endsection
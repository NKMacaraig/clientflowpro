@extends('admin')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
    <div>
        <h2>Projects</h2>
        <p style="color:#6b7280;">Track and manage all your client projects</p>
    </div>

    <button class="btn" onclick="openProjectModal()">+ Add Project</button>
</div>

<!-- ================= ADD PROJECT MODAL ================= -->
<div id="projectModal" class="modal">
    <div class="modal-card">

        <!-- HEADER -->
        <div class="modal-header">
            <h2>Create Project</h2>
            <span class="close" onclick="closeProjectModal()">×</span>
        </div>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- PROJECT TITLE -->
            <label>Project Title</label>
            <input type="text" name="project_name" placeholder="Enter project title" required>

            <!-- DESCRIPTION -->
            <label>Description</label>
            <textarea name="description" rows="3" placeholder="Write project details..."></textarea>

            <!-- CLIENT -->
            <label>Client</label>
            <select name="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">
                        {{ $client->company_name }}
                    </option>
                @endforeach
            </select>

            <!-- ADD PEOPLE -->
            <label>Assign Team</label>
            <input type="text" id="userSearch" placeholder="Type name (e.g. A)">
            <div id="userDropdown" class="dropdown"></div>

            <div id="selectedUsers" class="selected-users"></div>
            <input type="hidden" name="users" id="usersInput">

            <!-- DATES -->
            <div class="row">
                <div>
                    <label>Start Date</label>
                    <input type="date" name="start_date" required>
                </div>

                <div>
                    <label>End Date</label>
                    <input type="date" name="end_date" required>
                </div>
            </div>

            <!-- STATUS -->
            <label>Status</label>
            <select name="status">
                <option value="Planning">Planning</option>
                <option value="In Progress">In Progress</option>
                <option value="Review">Review</option>
                <option value="Completed">Completed</option>
            </select>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeProjectModal()">Cancel</button>
                <button type="submit" class="btn-submit">Create Project</button>
            </div>

        </form>
    </div>
</div>

<!-- TOP CARDS -->
<div class="cards">
    <div class="card">
        <h4>Healthy Projects</h4>
        <h2>{{ $healthy }}</h2>
    </div>

    <div class="card">
        <h4>At Risk</h4>
        <h2>{{ $risk }}</h2>
    </div>

    <div class="card">
        <h4>Critical</h4>
        <h2>{{ $critical }}</h2>
    </div>
</div>

<!-- FILTER BUTTONS -->
<div style="margin:20px 0;">
    <button class="btn filter-btn" onclick="filterProjects('all', this)">All Projects</button>
    <button class="btn filter-btn" onclick="filterProjects('active', this)">In Progress</button>
    <button class="btn filter-btn" onclick="filterProjects('planning', this)">Planning</button>
    <button class="btn filter-btn" onclick="filterProjects('pending', this)">Review</button>
    <button class="btn filter-btn" onclick="filterProjects('completed', this)">Completed</button>
</div>

<!-- PROJECT CARDS -->
<div class="grid">

@foreach($projects as $project)
<div class="card project-card" data-status="{{ strtolower(trim($project->status)) }}">

    <h4>{{ $project->project_name }}</h4>
    <p style="color:#6b7280;">{{ $project->client->company_name ?? '' }}</p>

    <br>

    <span class="badge active">{{ ucfirst($project->status) }}</span>

    <br><br>

    @php $progress = rand(40,100); @endphp

    <div style="background:#eee; height:6px; border-radius:10px;">
        <div style="width:{{ $progress }}%; height:6px; background:#6366f1; border-radius:10px;"></div>
    </div>

    <p style="font-size:12px;">{{ $progress }}%</p>

</div>
@endforeach

</div>

<!-- JAVASCRIPT -->
<script>
function filterProjects(status, btn) {
    let cards = document.querySelectorAll('.project-card');
    let buttons = document.querySelectorAll('.filter-btn');

    // reset all buttons
    buttons.forEach(b => {
        b.style.background = '#e5e7eb';
        b.style.color = '#111';
    });

    // highlight active button
    if (btn) {
        btn.style.background = '#6366f1';
        btn.style.color = '#fff';
    }

    // filter cards
    cards.forEach(card => {
        let cardStatus = card.getAttribute('data-status');

        if (status === 'all' || cardStatus === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

<script>

let users = @json($users);
let selectedUsers = [];

// OPEN / CLOSE
function openProjectModal() {
    document.getElementById("projectModal").style.display = "block";
}
function closeProjectModal() {
    document.getElementById("projectModal").style.display = "none";
}

// SEARCH USERS
document.getElementById("userSearch").addEventListener("keyup", function() {
    let input = this.value.toLowerCase();
    let dropdown = document.getElementById("userDropdown");

    dropdown.innerHTML = "";

    if (!input) return;

    let filtered = users.filter(u => u.name.toLowerCase().startsWith(input));

    filtered.forEach(user => {
        let div = document.createElement("div");
        div.innerText = user.name;

        div.onclick = () => addUser(user);

        dropdown.appendChild(div);
    });
});

// ADD USER
function addUser(user) {
    if (selectedUsers.includes(user.id)) return;

    selectedUsers.push(user.id);
    document.getElementById("usersInput").value = selectedUsers.join(',');

    let tag = document.createElement("span");
    tag.innerText = user.name + " ✕";

    tag.onclick = () => {
        selectedUsers = selectedUsers.filter(id => id !== user.id);
        document.getElementById("usersInput").value = selectedUsers.join(',');
        tag.remove();
    };

    document.getElementById("selectedUsers").appendChild(tag);
}

</script>



@endsection
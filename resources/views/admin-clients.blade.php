@extends('admin')

@section('content')

<h2>Clients</h2>
<p style="color:#6b7280; margin-bottom:15px;">Manage your client relationships and contacts</p>

<div class="table-box">

<div class="table-header">
    <input id="searchInput" type="text" class="search-box" placeholder="Search clients..." onkeyup="searchClients()">
    <button class="btn-add" onclick="openModal()">+ Add Client</button>
</div>

<!-- ================= ADD MODAL ================= -->
<div id="clientModal" class="modal">
    <div class="modal-card">
        
        <div class="modal-header">
            <h2>Add Client</h2>
            <span class="close" onclick="closeModal()">×</span>
        </div>

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <label>Company Name</label>
            <input type="text" name="company_name">

            <label>Contact Name</label>
            <input type="text" name="contact_person">

            <label>Email</label>
            <input type="email" name="email">

            <label>Phone</label>
            <input type="text" name="phone">

            <label>Address</label>
            <input type="text" name="address" required>

            <label>Status</label>
            <select name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit">Add Client</button>
            </div>
        </form>

    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div id="editModal" class="modal">
    <div class="modal-card">
        
        <div class="modal-header">
            <h2>Edit Client</h2>
            <span class="close" onclick="closeEditModal()">×</span>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id">

            <label>Company Name</label>
            <input type="text" id="edit_company" name="company_name">

            <label>Contact Name</label>
            <input type="text" id="edit_contact" name="contact_person">

            <label>Email</label>
            <input type="email" id="edit_email" name="email">

            <label>Phone</label>
            <input type="text" id="edit_phone" name="phone">

            <label>Address</label>
            <input type="text" id="edit_address" name="address">

            <label>Status</label>
            <select id="edit_status" name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-submit">Update</button>
            </div>
        </form>

    </div>
</div>

<!-- ================= TABLE ================= -->
<table>
    <thead>
        <tr>
            <th>COMPANY</th>
            <th>CONTACT</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>STATUS</th>
            <th>ACTIVITY</th>
        </tr>
    </thead>

    <tbody  id="clientTable">
        @foreach($clients as $client)
        <tr>
            <td>{{ $client->company_name }}</td>
            <td>{{ $client->contact_person }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->phone }}</td>
            <td>
                <span class="badge {{ $client->status == 'Active' ? 'active' : 'inactive' }}">
                    {{ $client->status ?? 'Active' }}
                </span>
            </td>

            <td>
                <button class="btn-edit"
                    onclick="openEditModal(
                        '{{ $client->id }}',
                        '{{ $client->company_name }}',
                        '{{ $client->contact_person }}',
                        '{{ $client->email }}',
                        '{{ $client->phone }}',
                        '{{ $client->address }}',
                        '{{ $client->status }}'
                    )">
                    Edit
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<!-- ================= SCRIPT ================= -->
<script>

function openModal() {
    document.getElementById("clientModal").style.display = "block";
}

function closeModal() {
    document.getElementById("clientModal").style.display = "none";
}

function openEditModal(id, company, contact, email, phone, address, status) {

    document.getElementById("editForm").action = "/clients/" + id;

    document.getElementById("edit_company").value = company;
    document.getElementById("edit_contact").value = contact;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_phone").value = phone;
    document.getElementById("edit_address").value = address;
    document.getElementById("edit_status").value = status;

    document.getElementById("editModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

// close modal if clicked outside
window.onclick = function(e) {
    if (e.target === document.getElementById("clientModal")) {
        closeModal();
    }
    if (e.target === document.getElementById("editModal")) {
        closeEditModal();
    }
}

function searchClients() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.querySelector("table tbody");
    let rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        let company = rows[i].getElementsByTagName("td")[0];
        let contact = rows[i].getElementsByTagName("td")[1];

        if (company || contact) {
            let companyText = company.textContent.toLowerCase();
            let contactText = contact.textContent.toLowerCase();

            if (companyText.startsWith(input) || contactText.startsWith(input)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}

</script>



@endsection
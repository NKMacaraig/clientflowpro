<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ClientFlow Pro</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* RESET */
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background:#f8fafc;
}

/* LAYOUT */
.layout {
    display:flex;
}

/* SIDEBAR */
.sidebar {
    width:250px;
    height:100vh;
    background:#ffffff;
    border-right:1px solid #e5e7eb;
    padding:20px;
}

.logo {
    font-weight:600;
    font-size:18px;
    margin-bottom:25px;
}

.menu-title {
    font-size:12px;
    color:#9ca3af;
    margin:15px 0 5px;
}

.sidebar a {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    border-radius:8px;
    color:#374151;
    text-decoration:none;
    font-size:14px;
}

.sidebar a.active,
.sidebar a:hover {
    background:#eef2ff;
    color:#4f46e5;
}

/* MAIN */
.main {
    flex:1;
}

/* NAVBAR */
.navbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 25px;
    background:#fff;
    border-bottom:1px solid #e5e7eb;
}

.search-box {
    background:#f1f5f9;
    padding:8px 12px;
    border-radius:8px;
    width:350px;
    border:none;
}

.nav-right {
    display:flex;
    align-items:center;
    gap:15px;
}

.btn {
    background:#6366f1;
    color:#fff;
    padding:8px 15px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:13px;
}

/* CONTENT */
.content {
    padding:25px;
}

/* CARDS */
.cards {
    display:flex;
    gap:20px;
    margin:20px 0;
}

.card {
    background:#fff;
    padding:20px;
    border-radius:12px;
    flex:1;
    border:1px solid #e5e7eb;
}

.card h4 {
    font-size:13px;
    color:#6b7280;
    margin-bottom:10px;
}

.card h2 {
    font-size:22px;
}

/* GRID */
.grid {
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:20px;
}

/* TABLE */
.table-box {
    background:#fff;
    border-radius:12px;
    border:1px solid #e5e7eb;
    margin-top:20px;
}

.table-header {
    padding:15px;
    display:flex;
    justify-content:space-between;
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:12px;
    font-size:14px;
    text-align:left;
}

thead {
    background:#f9fafb;
    color:#6b7280;
    font-size:12px;
}

tr {
    border-top:1px solid #eee;
}

/* BADGE */
.badge {
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
}

/* DROP DOWN */
.dropdown-btn {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    cursor:pointer;
    border-radius:8px;
}

.dropdown-btn:hover {
    background:#eef2ff;
    color:#4f46e5;
}

.dropdown-menu {
    display:block;
    margin-left:25px;
}

.dropdown-menu a {
    display:block;
    padding:8px;
    font-size:13px;
    color:#6b7280;
    border-radius:6px;
}

.dropdown-menu a.active,
.dropdown-menu a:hover {
    background:#eef2ff;
    color:#4f46e5;
}

.sidebar-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    border-radius:8px;
    font-size:14px;
    color:#9ca3af;
    cursor:default;
}

.sidebar-item i {
    width:16px;
}

/* optional hover (subtle, not clickable) */
.sidebar-item:hover {
    background:#f3f4f6;
}

/* add clients modal */
/* Background overlay */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    inset: 0;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
}

/* Card container */
.modal-card {
    background: #f9fafc;
    width: 420px;
    margin: 60px auto;
    padding: 20px 22px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    animation: fadeIn 0.25s ease;
}

/* Header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.modal-header h2 {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
}

.close {
    font-size: 20px;
    cursor: pointer;
    color: #888;
}

/* Labels */
form label {
    font-size: 13px;
    color: #6b7280;
    display: block;
    margin-bottom: 4px;
}

/* Inputs */
form input,
form select {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: #fff;
    font-size: 14px;
    outline: none;
    transition: 0.2s;
}

form input:focus,
form select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.1);
}

/* Footer buttons */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
}

/* Buttons */
.btn-add {
    background: #6366f1;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-submit {
    background: #6366f1;
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-cancel {
    background: #e5e7eb;
    color: #374151;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #3b82f6;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 13px;
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* INVOICES */
.invoice-container {
    padding: 20px;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.invoice-header h2 {
    margin: 0;
}

.invoice-header p {
    color: #6b7280;
    font-size: 14px;
}

.btn-create {
    background: #4f46e5;
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
}

.cards {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.card {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.card.green h3 {
    color: #16a34a;
}

.card.red h3 {
    color: #dc2626;
}

.filters {
    margin: 20px 0;
}

.filters button {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    background: #e5e7eb;
    margin-right: 8px;
    cursor: pointer;
}

.filters .active {
    background: #4f46e5;
    color: #fff;
}

.table-box {
    background: #fff;
    border-radius: 12px;
    padding: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f3f4f6;
}

th, td {
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

.invoice-id {
    color: #4f46e5;
    font-weight: bold;
}

.status {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
}

.status.paid {
    background: #dcfce7;
    color: #16a34a;
}

.status.unpaid {
    background: #fef3c7;
    color: #d97706;
}

.status.overdue {
    background: #fee2e2;
    color: #dc2626;
}

.text-red {
    color: #dc2626;
}

.action {
    margin-right: 10px;
    cursor: pointer;
    color: #6b7280;
}

.active { background:#dcfce7; color:#166534; }
.inactive { background:#f3f4f6; color:#6b7280; }

</style>
</head>

<body>

<div class="layout">

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">ClientFlow Pro</div>

    <div class="menu-title">OVERVIEW</div>
        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa fa-home"></i> Dashboard
        </a>

    <div class="menu-title">WORK</div>
        <a href="/admin/clients" class="{{ request()->is('admin/clients') ? 'active' : '' }}">
            <i class="fa fa-users"></i> Clients
        </a>

    <div class="dropdown">
        <div class="dropdown-btn" onclick="toggleDropdown()">
            <i class="fa fa-briefcase"></i> Projects
            <span style="margin-left:auto;">▼</span>
        </div>

        <div id="projectMenu" class="dropdown-menu">
            <a href="/admin/projects" class="{{ request()->is('admin/projects') ? 'active' : '' }}">
                Overview
            </a>

            <a href="/admin/tasks" class="{{ request()->is('admin/tasks') ? 'active' : '' }}">
                Tasks
            </a>
        </div>
    </div>


    
        <div class="menu-title">FINANCE</div>

    <div class="sidebar-item">
        <a href="{{ route('admin.invoices') }}">
            <i class="fa fa-file-invoice"></i> Invoices
        </a>
    </div>
            <div class="sidebar-item">
                <i class="fa fa-credit-card"></i> Payments
            </div>

            <div class="sidebar-item">
                <i class="fa fa-chart-line"></i> Analytics
            </div>

        
</div>

<!-- MAIN -->
<div class="main">

<!-- NAVBAR -->
<div class="navbar">
    <input type="text" class="search-box" placeholder="Search clients, projects, tasks...">

    <div class="nav-right">
        <button class="btn">+ Quick Create</button>
        <div>John Doe</div>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

</div>
</div>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById("projectMenu");
            menu.style.display = menu.style.display === "none" ? "block" : "none";
        }
    </script>

</body>
</html>
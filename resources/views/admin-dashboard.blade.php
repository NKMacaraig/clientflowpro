@extends('admin')

@section('content')

<div class="dashboard-header">
    <div>
        <h2>Dashboard</h2>
        <p>Welcome back! Here’s what’s happening today.</p>
    </div>
</div>

<!-- CARDS -->
<div class="cards">

    <div class="card stat-card">
        <div>
            <h4>Total Clients</h4>
            <h2>{{ $totalClients }}</h2>
        </div>
        <div class="icon blue">👥</div>
    </div>

    <div class="card stat-card">
        <div>
            <h4>Active Projects</h4>
            <h2>{{ $activeProjects }}</h2>
        </div>
        <div class="icon purple">📁</div>
    </div>

    <div class="card stat-card">
        <div>
            <h4>Tasks Completed</h4>
            <h2>{{ $completedTasks }}</h2>
        </div>
        <div class="icon green">✅</div>
    </div>

    <div class="card stat-card">
        <div>
            <h4>Monthly Revenue</h4>
            <h2>₱{{ number_format($monthlyRevenue,2) }}</h2>
        </div>
        <div class="icon yellow">💰</div>
    </div>

</div>

<!-- CHARTS -->
<div class="grid">

    <div class="card chart-card">
        <div class="card-header">
            <h4>Project Status Overview</h4>
        </div>
        <canvas id="barChart"></canvas>
    </div>

    <div class="card chart-card">
        <div class="card-header">
            <h4>Revenue Overview</h4>
        </div>
        <canvas id="lineChart"></canvas>
    </div>

</div>

<script>
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($projectStatuses->toArray())) !!},
            datasets: [{
                label: 'Projects',
                data: {!! json_encode(array_values($projectStatuses->toArray())) !!},
                backgroundColor: '#6366f1',
                borderRadius: 6
            }]
        },
        options: {
            responsive:true,
            plugins: {
                legend: { display:false }
            }
        }
    });

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($totals) !!},
                fill:true,
                borderColor:'#10b981',
                backgroundColor:'rgba(16,185,129,0.15)',
                tension:0.4
            }]
        },
        options: {
            responsive:true,
            plugins: {
                legend: { display:false }
            }
        }
    });
</script>

@endsection
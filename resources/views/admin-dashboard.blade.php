@extends('admin')

@section('content')

<h2>Dashboard</h2>

<div class="cards">
    <div class="card">
        <h4>Total Clients</h4>
        <h2>{{ $totalClients }}</h2>
    </div>

    <div class="card">
        <h4>Active Projects</h4>
        <h2>{{ $activeProjects }}</h2>
    </div>

    <div class="card">
        <h4>Tasks Completed</h4>
        <h2>{{ $completedTasks }}</h2>
    </div>

    <div class="card">
        <h4>Monthly Revenue</h4>
        <h2>₱{{ number_format($monthlyRevenue,2) }}</h2>
    </div>
</div>

<div class="grid">
    <div class="card">
        <canvas id="barChart"></canvas>
    </div>

    <div class="card">
        <canvas id="lineChart"></canvas>
    </div>
</div>

<script>
    // PROJECT STATUS BAR CHART
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($projectStatuses->toArray())) !!},
            datasets: [{
                label: 'Projects',
                data: {!! json_encode(array_values($projectStatuses->toArray())) !!},
                backgroundColor: '#6366f1'
            }]
        },
        options: { responsive:true }
    });

    // REVENUE LINE CHART
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($totals) !!},
                fill:true,
                borderColor:'#10b981',
                backgroundColor:'rgba(16,185,129,0.2)',
                tension:0.4
            }]
        },
        options: { responsive:true }
    });
</script>

@endsection
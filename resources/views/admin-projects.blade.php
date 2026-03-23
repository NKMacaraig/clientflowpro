@extends('admin')

@section('content')

<h2>Projects</h2>
<p style="color:#6b7280;">Track and manage all your client projects</p>

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

<!-- TABS -->
<div style="margin:20px 0;">
    <button class="btn">All Projects</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">In Progress</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">Planning</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">Review</button>
    <button class="btn" style="background:#e5e7eb; color:#111;">Completed</button>
</div>

<!-- PROJECT CARDS -->
<div class="grid">

@foreach($projects as $project)
<div class="card">

    <h4>{{ $project->name }}</h4>
    <p style="color:#6b7280;">{{ $project->client->company_name ?? '' }}</p>

    <br>

    <span class="badge active">{{ ucfirst($project->status) }}</span>

    <br><br>

    @php $progress = rand(40,100); @endphp

    <div style="background:#eee; height:6px; border-radius:10px;">
        <div style="width:{{ $progress }}%; height:6px; background:#6366f1;"></div>
    </div>

    <p style="font-size:12px;">{{ $progress }}%</p>

</div>
@endforeach

</div>

@endsection
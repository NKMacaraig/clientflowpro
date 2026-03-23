<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>ClientFlow Pro</title>

<link rel="stylesheet" href="{{ asset('signup.css') }}">

</head>

<body>

<div class="left">

<div class="signup-container">

<h2>Sign up for ClientFlow Pro</h2>

<form action="{{ route('signup.store') }}" method="POST">
    @csrf

    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter Here" required>
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter Here" required>
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Here" required>
    </div>

    <!-- Hidden Role Field -->
    <input type="hidden" name="role" value="staff">

    <button class="signup-btn" type="submit">Sign up</button>

    <button type="button" class="later-btn" onclick="window.location='{{ route('welcome') }}'">
        Maybe Later
    </button>
</form>

</div>

</div>


<div class="right">

<div class="info-container">

<h1>Create your account</h1>

<p>Explore ClientFlow Pro's core features for individuals and organizations</p>

<div class="feature">
<div class="feature-title">Project Management</div>
<div class="feature-desc">
Create client-based projects, assign team members, set milestones and deadlines, and track project progress in one place.
</div>
</div>

<div class="feature">
<div class="feature-title">Task Management</div>
<div class="feature-desc">
Create and assign tasks, track their progress, and view a personal task list.
</div>
</div>

<div class="feature">
<div class="feature-title">Invoice and Billing</div>
<div class="feature-desc">
Create project-linked invoices, monitor their payment status, and review invoice history.
</div>
</div>

<div class="feature">
<div class="feature-title">Client Management & Analytics</div>
<div class="feature-desc">
View insights including total clients, project progress, task completion rates, and monthly revenue.
</div>
</div>

</div>

</div>

</body>
</html>
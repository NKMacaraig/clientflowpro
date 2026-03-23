<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Client Flow Pro</title>

<link rel="stylesheet" href="{{ asset('style.css') }}">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<nav class="navbar">

<div class="logo">
<i class="fa-brands fa-figma"></i>
<span>Client Flow Pro</span>
</div>

<div class="nav-buttons">
<a href="{{ route('signup') }}" class="signup">Sign up</a>
<a href="#" class="login" onclick="toggleLogin()">Log in</a>
</div> 

<div id="loginPopup" class="login-popup">

<h2>Welcome Back!</h2>
<p class="login-sub">Log in to ClientFlow Pro</p>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
<p style="color:red;">{{ session('error') }}</p>
@endif

<form method="POST" action="/login">
@csrf

<label>Email</label>
<input type="email" name="email" placeholder="Enter Here" required>

<label>Password</label>
<input type="password" name="password" placeholder="Enter Here" required>

<button type="submit">Login</button>

</form>

</div>

</nav>

<section class="hero">

<h1>The All-in-One Client <br> Management Solution</h1>

<p>
Manage clients, projects, tasks, and billing with ease.
Save time, stay organized, and grow your business.
</p>

</section>


<section class="features">

<h2>Centralize Your Client Management</h2>

<p class="subtext">
Everything you need to manage your clients, projects, and billing – all in one place.
</p>

<div class="cards">

<div class="card">
<div class="icon-box">
<i class="fa-solid fa-users"></i>
</div>
<h3>Manage Clients</h3>
</div>

<div class="card">
<div class="icon-box">
<i class="fa-solid fa-folder"></i>
</div>
<h3>Track Projects</h3>
</div>

<div class="card">
<div class="icon-box">
<i class="fa-solid fa-file-invoice"></i>
</div>
<h3>Manage Invoices</h3>
</div>

<div class="card">
<div class="icon-box">
<i class="fa-solid fa-chart-column"></i>
</div>
<h3>Admin Dashboard</h3>
</div>

</div>

</section>


<section class="why">

<h2>Why Choose ClientFlow Pro?</h2>

<p class="subtext">
Increasing your team's efficiency with structured task management,
tracking, and an easy-to-use platform.
</p>

<div class="cards">

<div class="card large">

<div class="icon-box blue">
<i class="fa-solid fa-bolt"></i>
</div>

<h3>Streamline Your Workflow</h3>

<p>
Automate repetitive tasks and focus on what matters most.
</p>

</div>


<div class="card large">

<div class="icon-box blue">
<i class="fa-solid fa-chart-line"></i>
</div>

<h3>Improve Productivity</h3>

<p>
Track progress and optimize team performance effortlessly.
</p>

</div>


<div class="card large">

<div class="icon-box blue">
<i class="fa-solid fa-lock"></i>
</div>

<h3>Secure & Reliable</h3>

<p>
Enterprise-grade security to protect your client data.
</p>

</div>

</div>

</section>

<script>
function toggleLogin(){
let popup = document.getElementById("loginPopup");
popup.style.display = "block";
}

window.onclick = function(event){
let popup = document.getElementById("loginPopup");
if(event.target == popup){
popup.style.display = "none";
}
}
</script>

</body>
</html>
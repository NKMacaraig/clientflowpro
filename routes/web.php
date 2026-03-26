<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/* HOME */
Route::get('/', function () {
    return view('welcome');
});

/* LOGIN */
Route::post('/login', [LoginController::class, 'login']);

/* ADMIN DASHBOARD */
Route::get('/admin/dashboard', function () {
    return view('admin-dashboard');
});

/* STAFF DASHBOARD */
Route::get('/staff/dashboard', function () {
    return view('staff-dashboard');
});

/* SIGNUP PAGE */
Route::get('/signup', [SignupController::class, 'show'])->name('signup');

/* SIGNUP SUBMIT */
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

/* OPTIONAL (for Maybe Later button) */
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/* ADMIN */
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/clients', [AdminController::class, 'clients']);

/* CLIENT */
Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

/* INVOICES */
Route::get('/admin/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');
Route::get('/admin/invoices/{invoice}/download', [AdminController::class, 'downloadInvoice'])->name('admin.invoices.download');

/* PROJECT TASK */
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/admin/projects', [ProjectController::class, 'index'])->name('projects.index');

/* TASK */
Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin-tasks');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
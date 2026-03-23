<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;


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
Route::get('/admin/projects', [AdminController::class, 'projects']);
Route::get('/admin/tasks', [AdminController::class, 'tasks']);

/* CLIENT */
Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email','password'))) {

            $user = Auth::user();

            // AUTO DETECT ROLE
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role === 'staff') {
                return redirect('/staff/dashboard');
            }
        }

        return back()->with('error', 'Invalid email or password');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function show()
    {
        return view('signup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff' // <-- added role here
        ]);

        return redirect('/')->with('success','Account created successfully');
    }
}
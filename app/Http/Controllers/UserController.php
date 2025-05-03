<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display users
        return view('users.index');
    }

    public function show($id)
    {
        // Logic to retrieve and display a single user
        return view('users.show', ['id' => $id]);
    }

    public function create()
    {
        // Logic to show the form for creating a new user
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new user
        // Validate and save the user data
        return redirect()->route('users.index');
    }
    
}

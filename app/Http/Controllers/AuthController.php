<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return redirect()->intended('/');
        }
    
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'kelas' => 'nullable|string|max:50',
            'nomor_telpon' => 'nullable|string|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
    
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'kelas' => $request->kelas,
            'nomor_telpon' => $request->nomor_telpon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', // Default role set to 'user'
        ]);
    
        return redirect('/login')->with('success', 'Registrasi berhasil. Silahkan login.');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

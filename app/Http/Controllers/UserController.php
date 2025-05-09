<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'kelas' => 'nullable|string|max:50',
            'nomor_telpon' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => ['required', Rule::in(['super_admin', 'resepsionis', 'user'])],
        ]);

        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect('/user')->with('success', 'User has been added');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'kelas' => 'nullable|string|max:50',
            'nomor_telpon' => 'nullable|string|max:15',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'role' => ['required', Rule::in(['super_admin', 'resepsionis', 'user'])],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect('/user')->with('success', 'User has been updated');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'User has been deleted');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.show', compact('user'));
    }

    public function showProfile()
    {
        $user = Auth::user(); // ambil user yang sedang login
    
        return view('user.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
    return view('user.edit', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = User::findOrFail(Auth::id());

    $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'kelas' => 'nullable|string|max:255',
        'nomor_telpon' => 'nullable|string|max:20',
    ];

    if ($request->filled('password')) {
        $rules['password'] = 'required|string|min:6|confirmed';
    }

    $validated = $request->validate($rules);

    // Ganti field sesuai struktur tabel
    $user->nama = $validated['name'];
    $user->username = $validated['username'];
    $user->email = $validated['email'];
    $user->kelas = $validated['kelas'] ?? null;
    $user->nomor_telpon = $validated['telepon'] ?? null;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
}

}

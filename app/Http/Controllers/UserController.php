<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create() { return view('users.create', ['roles' => Role::all()]); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|exists:roles,name',
        ]);
        $u = User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);
        $u->assignRole($data['role']);
        return redirect()->route('users.index')->with('toast', 'User dibuat.');
    }

    public function show(User $user) { $user->load('roles'); return view('users.show', compact('user')); }
    public function edit(User $user) { return view('users.edit', ['user' => $user, 'roles' => Role::all()]); }

    public function update(Request $r, User $user)
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        $user->update($data);
        return back()->with('toast', 'User diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('toast', 'User dihapus.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('toast', 'Status user diubah.');
    }

    public function syncRoles(Request $r, User $user)
    {
        $user->syncRoles($r->input('roles', []));
        return back()->with('toast', 'Role disinkronkan.');
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('password')]);
        return back()->with('toast', 'Password direset ke "password".');
    }
}

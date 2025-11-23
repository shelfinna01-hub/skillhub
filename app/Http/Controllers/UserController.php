<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard');
        } elseif ($user->role === 'peserta') {
            $pendaftaran = $user->pendaftaran()->with('kelas')->latest()->get();
            return view('peserta.dashboard', compact('pendaftaran'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->oldest()->get();
        $pesertas = User::where('role', 'peserta')->oldest()->get();
        
        return view('admin.peserta.index', compact('admins', 'pesertas'));
    }

    public function create(Request $request)
    {
        $role = $request->get('role', 'peserta'); // Default to peserta
        return view('admin.peserta.create', compact('role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,peserta',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        $roleName = $validated['role'] === 'admin' ? 'Admin' : 'Peserta';
        return redirect()->route('admin.peserta.index')
            ->with('success', $roleName . ' berhasil ditambahkan.');
    }

    public function show(User $peserta)
    {
        return view('admin.peserta.show', compact('peserta'));
    }

    public function edit(User $peserta)
    {
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, User $peserta): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $peserta->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,peserta',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $peserta->update($validated);

        $roleName = $validated['role'] === 'admin' ? 'Admin' : 'Peserta';
        return redirect()->route('admin.peserta.index')
            ->with('success', $roleName . ' berhasil diupdate.');
    }

    public function destroy(User $peserta): RedirectResponse
    {
        if ($peserta->id === auth()->id()) {
            return redirect()->route('admin.peserta.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $roleName = $peserta->role === 'admin' ? 'Admin' : 'Peserta';
        $peserta->delete();

        return redirect()->route('admin.peserta.index')
            ->with('success', $roleName . ' berhasil dihapus.');
    }
}

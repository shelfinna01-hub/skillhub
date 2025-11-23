<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PendaftaranController
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'kelas'])->latest();

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $pendaftaran = $query->paginate(15);
        $pesertas = User::where('role', 'peserta')->get();
        $kelas = Kelas::all();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'pesertas', 'kelas'));
    }

    public function create(Request $request)
    {
        $pesertas = User::where('role', 'peserta')->get();
        $kelas = Kelas::all();
        $selectedPeserta = $request->get('peserta_id');

        return view('admin.pendaftaran.create', compact('pesertas', 'kelas', 'selectedPeserta'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'user_id.required' => 'Peserta harus dipilih.',
            'kelas_id.required' => 'Kelas harus dipilih.',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        if ($user->role !== 'peserta') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hanya peserta yang dapat didaftarkan ke kelas.');
        }

        $existing = Pendaftaran::where('user_id', $validated['user_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sudah terdaftar');
        }

        Pendaftaran::create([
            'user_id' => $validated['user_id'],
            'kelas_id' => $validated['kelas_id'],
        ]);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        if ($request->has('type') && $request->type === 'user') {
            $user = User::findOrFail($id);
            $pendaftaran = Pendaftaran::where('user_id', $id)->with('kelas')->get();
            return view('admin.pendaftaran.show-user', compact('user', 'pendaftaran'));
        }

        if ($request->has('type') && $request->type === 'kelas') {
            $kelas = Kelas::findOrFail($id);
            $pendaftaran = Pendaftaran::where('kelas_id', $id)->with('user')->get();
            return view('admin.pendaftaran.show-kelas', compact('kelas', 'pendaftaran'));
        }

        $pendaftaran = Pendaftaran::with(['user', 'kelas'])->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function destroy(Pendaftaran $pendaftaran): RedirectResponse
    {
        $userName = $pendaftaran->user->name;
        $kelasName = $pendaftaran->kelas->name;
        
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran $userName ke kelas $kelasName berhasil dibatalkan.");
    }
}


@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

        <div class="bg-white shadow rounded p-6">
            <p class="text-gray-700">Selamat datang, Admin!</p>

            <div class="mt-4 space-y-2">
                <a href="{{ route('admin.peserta.index') }}" class="text-blue-600 hover:text-blue-800 underline">Manajemen
                    Peserta</a><br>
                <a href="{{ route('admin.kelas.index') }}" class="text-blue-600 hover:text-blue-800 underline">Manajemen
                    Kelas</a><br>
                <a href="{{ route('admin.pendaftaran.index') }}"
                    class="text-blue-600 hover:text-blue-800 underline">Manajemen Pendaftaran</a>
            </div>

            <div class="mt-6 pt-6 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 underline">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
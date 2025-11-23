@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Detail Pendaftaran</h1>

        <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Peserta</label>
                <p class="text-gray-900 text-lg">{{ $pendaftaran->user->name }}</p>
                <p class="text-gray-500 text-sm">{{ $pendaftaran->user->email }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <p class="text-gray-900 text-lg">{{ $pendaftaran->kelas->name }}</p>
                <p class="text-gray-500 text-sm">Instruktur: {{ $pendaftaran->kelas->instructor }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kelas</label>
                <p class="text-gray-900 whitespace-pre-wrap">{{ $pendaftaran->kelas->description }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Daftar</label>
                <p class="text-gray-500 text-sm">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                <p class="text-gray-500 text-sm">{{ $pendaftaran->updated_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="flex space-x-4">
                <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Batalkan Pendaftaran
                    </button>
                </form>
                <a href="{{ route('admin.pendaftaran.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
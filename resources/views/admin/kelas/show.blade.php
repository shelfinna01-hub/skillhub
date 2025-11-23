@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Detail Kelas</h1>

        <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <p class="text-gray-900 text-lg">{{ $kelas->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Instruktur</label>
                <p class="text-gray-900">{{ $kelas->instructor }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <p class="text-gray-900 whitespace-pre-wrap">{{ $kelas->description }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                <p class="text-gray-500 text-sm">{{ optional($kelas->created_at)->format('d M Y, H:i') }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Diupdate</label>
                <p class="text-gray-500 text-sm">{{ optional($kelas->updated_at)->format('d M Y, H:i') }}</p>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('admin.kelas.edit', $kelas) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.kelas.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
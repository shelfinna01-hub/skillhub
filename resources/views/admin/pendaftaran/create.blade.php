@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Tambah Pendaftaran Baru</h1>

        <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
            <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Peserta <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Peserta --</option>
                        @foreach($pesertas as $peserta)
                            <option value="{{ $peserta->id }}" {{ old('user_id', $selectedPeserta) == $peserta->id ? 'selected' : '' }}>
                                {{ $peserta->name }} ({{ $peserta->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_id" id="kelas_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->name }} - {{ $k->instructor }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
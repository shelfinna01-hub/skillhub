@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Peserta yang Terdaftar di Kelas: {{ $kelas->name }}</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <p class="text-gray-900 text-lg">{{ $kelas->name }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Instruktur</label>
                <p class="text-gray-900">{{ $kelas->instructor }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Peserta</label>
                <p class="text-gray-900 text-lg font-semibold">{{ $pendaftaran->count() }} peserta</p>
            </div>
        </div>

        @if($pendaftaran->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                                Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendaftaran as $index => $p)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.peserta.show', $p->user) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $p->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.pendaftaran.destroy', $p) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Batalkan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white shadow rounded-lg p-12 text-center">
                <p class="text-gray-500">Belum ada peserta yang terdaftar di kelas ini.</p>
                <a href="{{ route('admin.pendaftaran.create') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                    Daftarkan Peserta
                </a>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke Daftar
                Pendaftaran</a>
        </div>
    </div>
@endsection
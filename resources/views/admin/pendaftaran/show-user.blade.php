@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Kelas yang Diikuti oleh {{ $user->name }}</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Peserta</label>
                <p class="text-gray-900 text-lg">{{ $user->name }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Kelas</label>
                <p class="text-gray-900 text-lg font-semibold">{{ $pendaftaran->count() }} kelas</p>
            </div>
        </div>

        @if($pendaftaran->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Instruktur</th>
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
                                    <a href="{{ route('admin.kelas.show', $p->kelas) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $p->kelas->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->kelas->instructor }}
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
                <p class="text-gray-500">Peserta ini belum terdaftar di kelas manapun.</p>
                <a href="{{ route('admin.pendaftaran.create', ['peserta_id' => $user->id]) }}"
                    class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                    Daftarkan ke Kelas
                </a>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.pendaftaran.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke Daftar
                Pendaftaran</a>
        </div>
    </div>
@endsection
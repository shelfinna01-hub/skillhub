@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manajemen Pendaftaran</h1>
            <a href="{{ route('admin.pendaftaran.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Tambah Pendaftaran Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Form -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Peserta</label>
                    <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Semua Peserta</option>
                        @foreach($pesertas as $peserta)
                            <option value="{{ $peserta->id }}" {{ request('user_id') == $peserta->id ? 'selected' : '' }}>
                                {{ $peserta->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Filter
                    </button>
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded ml-2">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Pendaftaran Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if($pendaftaran->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peserta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas
                            </th>
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
                                    {{ ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.pendaftaran.show', ['id' => $p->user_id, 'type' => 'user']) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        {{ $p->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="{{ route('admin.pendaftaran.show', ['id' => $p->kelas_id, 'type' => 'kelas']) }}"
                                        class="text-blue-600 hover:text-blue-900">
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

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pendaftaran->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <p class="text-gray-500">Belum ada pendaftaran yang terdaftar.</p>
                    <a href="{{ route('admin.pendaftaran.create') }}"
                        class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                        Tambah Pendaftaran Pertama
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke Dashboard</a>
        </div>
    </div>
@endsection
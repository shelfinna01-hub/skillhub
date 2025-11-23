@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard Peserta</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <p class="text-gray-700 text-lg">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Kelas yang Saya Ikuti</h2>

            @if($pendaftaran->count() > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                    Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Instruktur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendaftaran as $index => $p)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $p->kelas->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $p->kelas->instructor }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ Str::limit($p->kelas->description, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $p->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-12 text-center">
                    <p class="text-gray-500">Anda belum terdaftar di kelas manapun.</p>
                </div>
            @endif
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
@endsection
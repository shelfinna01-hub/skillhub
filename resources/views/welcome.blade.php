<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header Navigation -->
        <header class="w-full">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4 p-6">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('peserta.dashboard') }}"
                            class="inline-block px-5 py-1.5 border border-gray-300 hover:border-gray-400 rounded-sm text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 border border-transparent hover:border-gray-300 rounded-sm text-sm">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border border-gray-300 hover:border-gray-400 rounded-sm text-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Content - Centered Welcome Message -->
        <main class="flex-1 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900">Selamat datang</h1>
            </div>
        </main>
    </div>
</body>

</html>
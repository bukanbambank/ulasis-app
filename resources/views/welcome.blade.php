<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Ulasis 2.0') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="antialiased font-sans bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="relative min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-2">
                            <x-application-logo
                                class="block h-9 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
                            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Ulasis</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-4" x-data="{ 
                        darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            if (this.darkMode) {
                                document.documentElement.classList.add('dark');
                                localStorage.theme = 'dark';
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.theme = 'light';
                            }
                        }
                    }">
                        <button @click="toggle()"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700">
                            <!-- Sun Icon -->
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <!-- Moon Icon -->
                            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                        </button>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <h1
                    class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    <span class="block">Dengarkan Pelanggan</span>
                    <span class="block text-indigo-600 dark:text-indigo-400">Tingkatkan Kualitas Restoran</span>
                </h1>
                <p
                    class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Platform feedback berbasis QR code yang dirancang khusus untuk restoran dan café di Indonesia.
                    Dapatkan insight nyata dari pelanggan Anda dalam hitungan detik.
                </p>
                <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center gap-4">
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}"
                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            Mulai Sekarang
                        </a>
                    </div>
                    @auth
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('dashboard') }}"
                                class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                Ke Dashboard
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </main>

        <!-- Feature Highlights (Simple) -->
        <div class="bg-indigo-50 dark:bg-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm text-center">
                        <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-4">ΓÜí∩╕Å</div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">QR Code Cepat</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-300">Pelanggan scan dan beri feedback dalam < 60
                                detik.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm text-center">
                        <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-4">Γ£¿</div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Insight Nyata</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-300">Data analitik untuk keputusan yang lebih baik.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm text-center">
                        <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-4">Γ£à</div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Mudah Digunakan</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-300">Tanpa ribet, langsung siap pakai untuk UMKM.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Ulasis. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Thank You - Feedback</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">

            <div class="mb-4 text-green-500">
                <svg class="h-16 w-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Terima Kasih!</h2>
            <p class="text-gray-600 mb-6">Masukan Anda sangat berharga bagi kami untuk terus meningkatkan pelayanan.</p>

            <a href="/" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                Kembali ke Halaman Utama
            </a>

            <p class="text-xs text-gray-400 mt-8">Powered by Ulasis</p>
        </div>
    </div>
</body>

</html>
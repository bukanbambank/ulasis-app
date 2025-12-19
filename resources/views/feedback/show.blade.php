<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $questionnaire->title }} - Feedback</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Header -->
            <div class="text-center mb-8">
                @if($questionnaire->restaurant && $questionnaire->restaurant->logo)
                    <img src="{{ Storage::url($questionnaire->restaurant->logo) }}" alt="Logo" class="h-16 mx-auto mb-4">
                @elseif($questionnaire->tenant_id)
                    {{-- Fallback logic for tenant branding if needed --}}
                    <div
                        class="h-16 w-16 bg-indigo-100 text-indigo-500 rounded-full mx-auto mb-4 flex items-center justify-center font-bold text-xl">
                        {{ substr($questionnaire->restaurant->name ?? 'R', 0, 1) }}
                    </div>
                @endif
                <h1 class="text-2xl font-bold text-gray-800">{{ $questionnaire->title }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $questionnaire->restaurant->name ?? '' }}</p>
                <p class="text-xs text-gray-400 mt-2">ID: {{ $qrCode->name }}</p>
            </div>

            <!-- Form -->
            <form action="{{ route('feedback.store', $uuid) }}" method="POST" class="space-y-6">
                @csrf

                @foreach ($questionnaire->questions as $index => $question)
                    <div class="space-y-2">
                        <label class="block text-lg font-medium text-gray-900">
                            {{ $question['text'] }}
                            @if(!empty($question['required'])) <span class="text-red-500">*</span> @endif
                        </label>

                        @if ($question['type'] === 'rating')
                            <!-- Rating Component using Alpine for interactivity -->
                            <div x-data="{ rating: 0 }" class="flex items-center space-x-2 justify-center py-2">
                                <input type="hidden" name="ratings[{{ $question['id'] }}]" x-model="rating"
                                    @if(!empty($question['required'])) required @endif>
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" @click="rating = {{ $i }}"
                                        :class="{ 'text-yellow-400': rating >= {{ $i }}, 'text-gray-300': rating < {{ $i }} }"
                                        class="w-10 h-10 transition text-3xl focus:outline-none">
                                        ★
                                    </button>
                                @endfor
                            </div>

                        @elseif ($question['type'] === 'boolean')
                            <div x-data="{ val: null }" class="flex space-x-4">
                                <input type="hidden" name="ratings[{{ $question['id'] }}]" x-model="val"
                                    @if(!empty($question['required'])) required @endif>
                                <button type="button" @click="val = 'yes'"
                                    :class="val === 'yes' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-white border-gray-300 text-gray-700'"
                                    class="flex-1 py-3 border rounded-lg hover:bg-green-50 transition font-bold">
                                    Yes
                                </button>
                                <button type="button" @click="val = 'no'"
                                    :class="val === 'no' ? 'bg-red-100 border-red-500 text-red-700' : 'bg-white border-gray-300 text-gray-700'"
                                    class="flex-1 py-3 border rounded-lg hover:bg-red-50 transition font-bold">
                                    No
                                </button>
                            </div>

                        @elseif ($question['type'] === 'text')
                            <textarea name="ratings[{{ $question['id'] }}]"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                rows="3" placeholder="Tulis jawaban Anda..." @if(!empty($question['required'])) required
                                @endif></textarea>
                        @endif
                    </div>
                @endforeach

                <!-- General Feedback (Optional global field) -->
                <div class="pt-4 border-t border-gray-100 mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masukan Tambahan (Opsional)</label>
                    <textarea name="feedback_text"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        rows="2"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition shadow-lg transform hover:-translate-y-0.5">
                        Kirim Masukan
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4">Powered by Ulasis</p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
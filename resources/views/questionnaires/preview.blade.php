<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <!-- Mobile Container Simulation -->
        <div class="max-w-md mx-auto bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">

            <!-- Warning Banner -->
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Preview Mode</p>
                <p>Submit is disabled. Feedback will not be saved.</p>
            </div>

            <div class="p-6">
                <!-- Branding Header -->
                <div class="text-center mb-8">
                    @if($questionnaire->restaurant && $questionnaire->restaurant->logo)
                        <img src="{{ Storage::url($questionnaire->restaurant->logo) }}" alt="Logo"
                            class="h-16 mx-auto mb-4">
                    @elseif(Auth::user()->restaurant->logo)
                        <img src="{{ Storage::url(Auth::user()->restaurant->logo) }}" alt="Logo" class="h-16 mx-auto mb-4">
                    @else
                        <div class="h-16 w-16 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-gray-500 text-xs">Logo</span>
                        </div>
                    @endif
                    <h1 class="text-2xl font-bold text-gray-800">{{ $questionnaire->title }}</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ Auth::user()->restaurant->name }}</p>
                </div>

                <!-- Feedback Form Reused Component -->
                <x-feedback-form :questions="$questionnaire->questions" :preview="true" />
            </div>
        </div>
    </div>
</x-app-layout>
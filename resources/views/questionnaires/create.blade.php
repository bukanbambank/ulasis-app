<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Select a Template</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($templates as $key => $template)
                            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow cursor-pointer">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-100 p-3 rounded-full mr-4">
                                        <!-- Simple Icon Placeholder -->
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold">{{ $template['name'] }}</h4>
                                </div>
                                <p class="text-gray-600 mb-6">{{ $template['description'] }}</p>

                                <form action="{{ route('questionnaires.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="template" value="{{ $key }}">
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                                        Use Template
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feedback Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">

                <!-- Main Content -->
                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-2">Customer Feedback</h3>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-lg italic">
                                "{{ $feedback->feedback_text ?? 'No text feedback provided.' }}"
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-4">Ratings Breakdown</h3>
                            @if(is_array($feedback->ratings))
                                <div class="grid gap-4">
                                    @foreach($feedback->ratings as $questionId => $rating)
                                        <div class="flex justify-between items-center border-b dark:border-gray-700 pb-2">
                                            <span class="text-gray-600 dark:text-gray-300">
                                                Question {{ $loop->iteration }} (ID: {{ $questionId }})
                                                <!-- Note: Ideally we map Q-ID to text via Questionnaire Model, but for now we show raw ID/Value -->
                                            </span>
                                            <span class="font-bold text-indigo-600 dark:text-indigo-400">
                                                {{ $rating }} / 5
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No ratings data available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Metadata -->
                <div class="w-full md:w-1/3 space-y-6">
                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Actions</h3>

                        <form method="POST" action="{{ route('feedback-inbox.update', $feedback) }}"
                            class="mb-4 space-y-2">
                            @csrf
                            @method('PUT')
                            <button name="status" value="read"
                                class="w-full text-center px-4 py-2 border border-green-600 text-green-600 rounded hover:bg-green-50">
                                Mark as Read
                            </button>
                            <button name="status" value="archived"
                                class="w-full text-center px-4 py-2 border border-gray-600 text-gray-600 rounded hover:bg-gray-50">
                                Archive
                            </button>
                            <button name="status" value="unread"
                                class="w-full text-center px-4 py-2 border border-red-600 text-red-600 rounded hover:bg-red-50">
                                Mark as Unread
                            </button>
                        </form>

                        <form method="POST" action="{{ route('feedback-inbox.destroy', $feedback) }}"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full text-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete Feedback
                            </button>
                        </form>
                    </div>

                    <!-- Metadata -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-sm">
                        <h3 class="text-lg font-bold mb-4">Context</h3>
                        <p class="mb-2"><span class="font-semibold">Status:</span> {{ ucfirst($feedback->status) }}</p>
                        <p class="mb-2"><span class="font-semibold">Date:</span>
                            {{ $feedback->created_at->format('M d, Y H:i:s') }}</p>
                        <p class="mb-2"><span class="font-semibold">Source:</span>
                            {{ $feedback->qrCode->name ?? 'Unknown' }}</p>
                        <p class="mb-2"><span class="font-semibold">Feedback ID:</span> {{ $feedback->id }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
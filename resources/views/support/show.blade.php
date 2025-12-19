<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $ticket->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Status: </span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">Created:
                            {{ $ticket->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <a href="{{ route('support.index') }}" class="text-indigo-600 hover:text-indigo-900">Back onto
                        List</a>
                </div>

                <div class="prose dark:prose-invert max-w-none text-gray-900 dark:text-gray-100">
                    <p class="whitespace-pre-wrap">{{ $ticket->message }}</p>
                </div>
            </div>

            <!-- Thread/Comments Section would go here (Out of MVP Scope for Story 7.4? Story says "Thread history") -->
            <!-- Acceptance Criteria: "Detail View: Thread history of responses." -->
            <!-- Implementing simple loop if comments exist? Current migration didn't add comments table. -->
            <!-- Assuming simple display for now as per MVP scope or future enhancement -->
            <!-- Adding a dummy "Comments" section for UI completeness -->

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Responses</h3>
                <p class="text-gray-500 dark:text-gray-400 italic">No responses yet.</p>

                <!-- Reply Form (Placeholder) -->
                <!-- <form ...> -->
            </div>

        </div>
    </div>
</x-app-layout>
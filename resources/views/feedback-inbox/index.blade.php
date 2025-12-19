<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feedback Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filters -->
                    <div class="mb-4 flex flex-col md:flex-row gap-4">
                        <form method="GET" action="{{ route('feedback-inbox.index') }}"
                            class="flex gap-2 w-full md:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search feedback..."
                                class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm w-full">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">Search</button>
                        </form>

                        <div class="flex gap-2">
                            <a href="{{ route('feedback-inbox.index', ['status' => 'unread']) }}"
                                class="px-3 py-2 rounded-md {{ request('status') == 'unread' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 dark:bg-gray-700' }}">Unread</a>
                            <a href="{{ route('feedback-inbox.index', ['status' => 'read']) }}"
                                class="px-3 py-2 rounded-md {{ request('status') == 'read' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 dark:bg-gray-700' }}">Read</a>
                            <a href="{{ route('feedback-inbox.index', ['status' => 'archived']) }}"
                                class="px-3 py-2 rounded-md {{ request('status') == 'archived' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 dark:bg-gray-700' }}">Archived</a>
                            <a href="{{ route('feedback-inbox.index') }}"
                                class="px-3 py-2 rounded-md {{ !request('status') ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 dark:bg-gray-700' }}">All</a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Source</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Feedback</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $feedback)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">
                                            {{ $feedback->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $feedback->qrCode->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight rounded-full {{ $feedback->status === 'unread' ? 'text-red-700 bg-red-100' : ($feedback->status === 'read' ? 'text-green-700 bg-green-100' : 'text-gray-700 bg-gray-100') }}">
                                                {{ ucfirst($feedback->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 max-w-xs truncate">
                                            {{ $feedback->feedback_text ?? 'No text feedback' }}
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('feedback-inbox.show', $feedback) }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center">No feedback found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
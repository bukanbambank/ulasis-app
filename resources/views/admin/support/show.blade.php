<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket #') . $support->id . ': ' . $support->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex gap-6">
                <!-- Thread -->
                <div class="w-full md:w-2/3">
                    <!-- Original Message -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                        <div class="flex justify-between items-center mb-4">
                            <span
                                class="font-bold text-gray-900 dark:text-gray-100">{{ $support->user->name ?? 'User' }}</span>
                            <span class="text-sm text-gray-500">{{ $support->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $support->message }}</p>
                    </div>

                    <!-- Replies -->
                    @foreach($support->replies as $reply)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4 {{ $reply->user_id === auth()->id() ? 'border-l-4 border-indigo-500' : '' }}">
                            <div class="flex justify-between items-center mb-4">
                                <span
                                    class="font-bold {{ $reply->user_id === auth()->id() ? 'text-indigo-600' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $reply->user->name ?? 'Unknown' }} {{ $reply->user->is_admin ? '(Admin)' : '' }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $reply->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $reply->message }}</p>
                        </div>
                    @endforeach

                    <!-- Reply Form -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Post a Reply</h3>
                        <form action="{{ route('admin.support.reply', $support) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="message" rows="4"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Type your reply here..." required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="w-full md:w-1/3">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Ticket Info</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">
                                    {{ $support->status }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">User Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $support->user->email ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $support->updated_at->diffForHumans() }}</dd>
                            </div>
                        </dl>
                        <div class="mt-6">
                            <a href="{{ route('admin.support.index') }}"
                                class="text-indigo-600 hover:text-indigo-900">Back to Inbox</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Support Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('support.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="subject" :value="__('Subject')" />
                        <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full"
                            :value="old('subject')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                    </div>

                    <div>
                        <x-input-label for="message" :value="__('Message')" />
                        <textarea id="message" name="message"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            rows="6" required>{{ old('message') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Submit Ticket') }}</x-primary-button>
                        <a href="{{ route('support.index') }}"
                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reports & Exports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-bold mb-4">Export Feedback Data</h3>
                <p class="mb-4 text-gray-600 dark:text-gray-400">
                    Download your customer feedback data for external analysis.
                </p>

                <form action="{{ route('reports.export') }}" method="POST" class="space-y-4 max-w-md">
                    @csrf

                    <div>
                        <label for="range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time
                            Range</label>
                        <select id="range" name="range"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="365">Last Year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>

                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">File
                            Format</label>
                        <select id="format" name="format"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="xlsx">Excel (.xlsx)</option>
                            <option value="csv">CSV (.csv)</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                <select name="range" onchange="this.form.submit()"
                    class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                    <option value="7" {{ $range == 7 ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $range == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="365" {{ $range == 365 ? 'selected' : '' }}>Last Year</option>
                    <option value="all" {{ $range == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Feedback -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Total
                        Feedback</div>
                    <div class="mt-2 text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                        {{ $stats['total_feedback'] }}</div>
                </div>

                <!-- Avg Rating -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Avg Rating
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span
                            class="text-3xl font-extrabold {{ $stats['avg_rating'] >= 4 ? 'text-green-600' : ($stats['avg_rating'] >= 3 ? 'text-yellow-500' : 'text-red-500') }}">
                            {{ $stats['avg_rating'] }}
                        </span>
                        <span class="text-sm text-gray-500">/ 5.0</span>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-center gap-2">
                    <a href="{{ route('feedback-inbox.index') }}"
                        class="text-indigo-600 hover:underline font-semibold">Go to Inbox &rarr;</a>
                    <a href="{{ route('qr-codes.index') }}" class="text-indigo-600 hover:underline font-semibold">Manage
                        QR Codes &rarr;</a>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Sentiment Pie Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Sentiment Distribution</h3>
                    <div class="h-64 relative">
                        <canvas id="sentimentChart"></canvas>
                    </div>
                </div>

                <!-- Trend Line Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Rating Trend</h3>
                    <div class="h-64 relative">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js Logic -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sentiment Chart
            const ctxSentiment = document.getElementById('sentimentChart').getContext('2d');
            new Chart(ctxSentiment, {
                type: 'doughnut',
                data: {
                    labels: @json($sentiment['labels']),
                    datasets: [{
                        data: @json($sentiment['data']),
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'], // Green, Yellow, Red
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Trend Chart
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: @json($trend['labels']),
                    datasets: [{
                        label: 'Average Rating',
                        data: @json($trend['data']),
                        borderColor: '#6366F1', // Indigo
                        tension: 0.3,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- User Count Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Total Users
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mt-2">
                        {{ $stats['total_users'] }}</div>
                </div>

                <!-- Failed Jobs Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase font-bold tracking-wider">Failed Jobs
                    </div>
                    <div class="text-3xl font-extrabold text-red-600 dark:text-red-400 mt-2">{{ $stats['failed_jobs'] }}
                    </div>
                </div>
            </div>

            <!-- New Registrations Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">New Registrations (Last 7 Days)</h3>
                <div class="relative h-64 w-full">
                    <canvas id="registrationsChart"></canvas>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Recent Registrations</h3>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_users'] as $user)
                            <tr>
                                <td
                                    class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                    <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">{{ $user->name }}</p>
                                </td>
                                <td
                                    class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                    <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">{{ $user->email }}</p>
                                </td>
                                <td
                                    class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                    <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                                        {{ $user->created_at->format('M d, Y') }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('registrationsChart').getContext('2d');
                const data = @json($registrations);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.date),
                        datasets: [{
                            label: 'Registrations',
                            data: data.map(item => item.count),
                            borderColor: 'rgb(79, 70, 229)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
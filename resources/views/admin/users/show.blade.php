<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'suspended' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                             @if($user->is_admin) <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Admin</span> @endif
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        @if($user->status !== 'suspended' && !$user->is_admin)
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to suspend this user?');">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    Suspend User
                                </button>
                            </form>
                        @elseif($user->status === 'suspended')
                            <form action="{{ route('admin.users.activate', $user) }}" method="POST" onsubmit="return confirm('Activate this user?');">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Activate User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="font-bold text-gray-900 dark:text-gray-100">Restaurant Details</h4>
                    @if($user->restaurant)
                        <dl class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->restaurant->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->restaurant->phone ?? '-' }}</dd>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $user->restaurant->address ?? '-' }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No restaurant linked.</p>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900">Back onto List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

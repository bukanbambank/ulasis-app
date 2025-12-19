<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Restaurant Name -->
        <div>
            <x-input-label for="restaurant_name" :value="__('Restaurant Name')" />
            <x-text-input id="restaurant_name" class="block mt-1 w-full" type="text" name="restaurant_name"
                :value="old('restaurant_name')" required autofocus autocomplete="organization" />
            <x-input-error :messages="$errors->get('restaurant_name')" class="mt-2" />
        </div>

        <!-- Owner Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Owner Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <a href="{{ route('social.redirect', 'google') }}"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 ms-3">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M21.35 11.1H12v3.1h5.64c-.45 2.1-2.2 3.6-4.64 3.6-2.8 0-5.1-2.3-5.1-5.1s2.3-5.1 5.1-5.1c1.2 0 2.3.4 3.2 1.2l2.3-2.3c-1.5-1.4-3.5-2.2-5.5-2.2-4.8 0-8.7 3.9-8.7 8.7s3.9 8.7 8.7 8.7c4.6 0 8.5-3.4 8.7-8h.05v-2.6z" />
                </svg>
                Google
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
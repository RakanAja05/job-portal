<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('HR Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, HR ") }} {{ Auth::user()?->name }}
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Role: {{ Auth::user()?->role ?? 'N/A' }}
                    </div>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
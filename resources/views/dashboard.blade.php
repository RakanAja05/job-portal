<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4">You're logged in!</p>
                    
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Role:</strong> {{ ucfirst(Auth::user()->role ?? 'N/A') }}
                        </p>
                    </div>

                    <div class="mt-6 space-y-4">
                        @if(Auth::user()->role === 'admin')
                            <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Admin Access</h4>
                                <p class="text-sm mb-4">You have administrative privileges</p>
                                <a href="{{ route('admin.jobs') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Go to Admin Jobs
                                </a>
                            </div>
                        @elseif(Auth::user()->role === 'user')
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">User Dashboard</h4>
                                <p class="text-sm mb-4">Access your personal dashboard</p>
                                <a href="{{ route('user.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Go to User Dashboard
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, Admin {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-600 mb-6">You are logged in as: <span class="font-semibold text-red-600">Administrator</span></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">Total Users</h4>
                            <p class="text-3xl font-bold mt-2">0</p>
                        </div>
                        
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">Active Jobs</h4>
                            <p class="text-3xl font-bold mt-2">0</p>
                        </div>
                        
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">Applications</h4>
                            <p class="text-3xl font-bold mt-2">0</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-xl font-semibold mb-4">Quick Actions</h4>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.settings') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Settings
                            </a>
                            <a href="{{ route('admin.reports') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                View Reports
                            </a>
                        </div>
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

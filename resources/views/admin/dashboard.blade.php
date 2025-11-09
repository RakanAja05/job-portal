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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Kelola Lowongan Kerja -->
                            <a href="{{ route('jobs.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 flex flex-col items-center">
                                <svg class="h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-center">Kelola Lowongan</span>
                            </a>

                            <!-- Manage Users -->
                            <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 flex flex-col items-center">
                                <svg class="h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-center">Manage Users</span>
                            </a>

                            <!-- Settings -->
                            <a href="{{ route('admin.settings') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 flex flex-col items-center">
                                <svg class="h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-center">Settings</span>
                            </a>

                            <!-- View Reports -->
                            <a href="{{ route('admin.reports') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 flex flex-col items-center">
                                <svg class="h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-center">View Reports</span>
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

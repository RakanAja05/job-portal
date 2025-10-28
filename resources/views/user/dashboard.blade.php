<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 mb-6">You are logged in as: <span class="font-semibold text-blue-600">{{ Auth::user()->role }}</span></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">My Profile</h4>
                            <p class="text-sm text-gray-600 mt-2">View and edit your profile information</p>
                            <a href="{{ route('user.profile') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                View Profile
                            </a>
                        </div>
                        
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">Activity</h4>
                            <p class="text-sm text-gray-600 mt-2">View your recent activities</p>
                            <button class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                View Activity
                            </button>
                        </div>
                        
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold">Settings</h4>
                            <p class="text-sm text-gray-600 mt-2">Manage your account settings</p>
                            <a href="{{ route('profile.edit') }}" class="mt-4 inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Settings
                            </a>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-xl font-semibold mb-4">Quick Info</h4>
                        <ul class="space-y-2">
                            <li><span class="font-semibold">Name:</span> {{ Auth::user()->name }}</li>
                            <li><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</li>
                            <li><span class="font-semibold">Role:</span> {{ Auth::user()->role }}</li>
                            <li><span class="font-semibold">Member Since:</span> {{ Auth::user()->created_at->format('F d, Y') }}</li>
                        </ul>
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

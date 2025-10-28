<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Profile Information</h3>
                    
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <p class="mt-1 text-lg">{{ Auth::user()->name }}</p>
                        </div>
                        
                        <div class="border-b pb-4">
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <p class="mt-1 text-lg">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="border-b pb-4">
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <p class="mt-1 text-lg">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="border-b pb-4">
                            <label class="block text-sm font-medium text-gray-700">Email Verified</label>
                            <p class="mt-1 text-lg">
                                @if(Auth::user()->email_verified_at)
                                    <span class="text-green-600">✓ Verified</span>
                                @else
                                    <span class="text-red-600">✗ Not Verified</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="pb-4">
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="mt-1 text-lg">{{ Auth::user()->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('user.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

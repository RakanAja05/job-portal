<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">System Settings</h3>
                    
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h4 class="font-semibold">Site Configuration</h4>
                            <p class="text-sm text-gray-600">Configure site settings and preferences</p>
                        </div>
                        
                        <div class="border-b pb-4">
                            <h4 class="font-semibold">Email Settings</h4>
                            <p class="text-sm text-gray-600">Configure email notifications and templates</p>
                        </div>
                        
                        <div class="border-b pb-4">
                            <h4 class="font-semibold">Security Settings</h4>
                            <p class="text-sm text-gray-600">Manage security and authentication settings</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.jobs') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

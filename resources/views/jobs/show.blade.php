<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Lowongan Kerja') }}
            </h2>
            <a href="{{ route('jobs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Card Container -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <!-- Header with Logo -->
                <div class="relative h-64 bg-gradient-to-r from-blue-500 to-purple-600">
                    @if($job->logo)
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="absolute inset-0 w-full h-full object-cover opacity-20">
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/60 to-transparent">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $job->title }}</h1>
                        <p class="text-xl text-gray-200">{{ $job->company }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <!-- Quick Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Location -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Lokasi</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $job->location }}</p>
                            </div>
                        </div>

                        <!-- Job Type -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jenis Pekerjaan</p>
                                <p class="text-lg font-semibold">
                                    <span class="px-3 py-1 rounded-full text-sm {{ $job->type == 'full-time' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($job->type) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Salary -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gaji</p>
                                @if($job->salary)
                                    <p class="text-lg font-semibold text-green-600">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>
                                @else
                                    <p class="text-lg font-semibold text-gray-400">Negotiable</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-8"></div>

                    <!-- Description Section -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Deskripsi Pekerjaan
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {{ $job->description }}
                        </div>
                    </div>

                    <!-- Company Logo (if available) -->
                    @if($job->logo)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Logo Perusahaan</h2>
                        <div class="bg-gray-50 rounded-lg p-6 flex justify-center">
                            <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="max-h-64 object-contain rounded shadow-md">
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 mt-8 pt-8 border-t border-gray-200">
                        @if(Auth::user()->role === 'admin')
                            <!-- Admin Actions -->
                            <a href="{{ route('jobs.edit', $job->id) }}" class="flex-1 min-w-[200px] bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 px-6 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Lowongan
                            </a>
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="flex-1 min-w-[200px]">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 px-6 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus Lowongan
                                </button>
                            </form>
                        @else
                            <!-- User Actions - Apply Button -->
                            <a href="{{ route('applications.create', $job->id) }}" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-4 px-8 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition duration-200 flex items-center justify-center">
                                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Lamar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Posted Date -->
            <div class="mt-4 text-center text-sm text-gray-500">
                <p>Dibuat pada: {{ $job->created_at->format('d F Y, H:i') }}</p>
                @if($job->created_at != $job->updated_at)
                    <p>Terakhir diperbarui: {{ $job->updated_at->format('d F Y, H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

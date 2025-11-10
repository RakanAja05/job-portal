<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lamar Pekerjaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Job Info Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                    <h3 class="text-2xl font-bold mb-2">{{ $job->title }}</h3>
                    <p class="text-lg">{{ $job->company }}</p>
                    <div class="flex items-center mt-3 text-sm">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $job->location }}
                        <span class="mx-2">•</span>
                        <span class="px-2 py-1 bg-white/20 rounded text-xs">{{ ucfirst($job->type) }}</span>
                        @if($job->salary)
                            <span class="mx-2">•</span>
                            <span class="font-semibold">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h4 class="text-xl font-bold mb-4">📄 Form Lamaran</h4>
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('applications.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- User Info (Read Only) -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                            <h5 class="font-bold text-gray-700 mb-2">Informasi Pelamar:</h5>
                            <p class="text-gray-700"><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                            <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        </div>

                        <!-- CV Upload -->
                        <div class="mb-6">
                            <label for="cv" class="block text-gray-700 text-sm font-bold mb-2">
                                📎 Upload CV (PDF) *
                            </label>
                            <input type="file" 
                                   name="cv" 
                                   id="cv" 
                                   accept=".pdf"
                                   required
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-blue-500 p-2.5
                                   @error('cv') border-red-500 @enderror">
                            <p class="text-gray-600 text-xs mt-2">
                                <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Format: PDF | Maksimal: 2MB
                            </p>
                            @error('cv')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Description Preview -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h5 class="font-bold text-gray-700 mb-2">📋 Deskripsi Pekerjaan:</h5>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $job->description }}</p>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="agreement" 
                                       required
                                       class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">
                                    Saya menyatakan bahwa data yang saya berikan adalah benar dan saya bersedia mengikuti proses seleksi yang ditetapkan perusahaan.
                                </span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <a href="{{ route('jobs.show', $job->id) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
                                <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Lamaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">💡 Tips Melamar:</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan CV Anda update dan profesional</li>
                                <li>Format CV dalam PDF untuk menjaga tampilan</li>
                                <li>Ukuran file maksimal 2MB</li>
                                <li>Cantumkan pengalaman dan skill yang relevan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

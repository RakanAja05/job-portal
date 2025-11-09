<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Lowongan Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Lowongan *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" 
                                placeholder="Contoh: Web Developer">
                            @error('title')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi *</label>
                            <textarea name="description" id="description" rows="5" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" 
                                placeholder="Deskripsi pekerjaan...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi *</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" 
                                placeholder="Contoh: Jakarta">
                            @error('location')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="company" class="block text-gray-700 text-sm font-bold mb-2">Nama Perusahaan *</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('company') border-red-500 @enderror" 
                                placeholder="Contoh: PT Technology Indonesia">
                            @error('company')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Gaji (Opsional)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary') }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('salary') border-red-500 @enderror" 
                                placeholder="Contoh: 5000000">
                            @error('salary')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Pekerjaan *</label>
                            <div class="mt-2">
                                <label class="inline-flex items-center mr-6">
                                    <input type="radio" name="type" value="full-time" {{ old('type', 'full-time') == 'full-time' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2">Full-time</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="part-time" {{ old('type') == 'part-time' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2">Part-time</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo Perusahaan (Opsional)</label>
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/jpg"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('logo') border-red-500 @enderror">
                            <p class="text-gray-600 text-xs mt-1">Format: JPG, PNG, JPEG. Max: 2MB</p>
                            @error('logo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Notification Field -->
                        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <label for="recipient_email" class="block text-gray-700 text-sm font-bold mb-2">
                                        📧 Email Notifikasi (Opsional)
                                    </label>
                                    <input type="email" name="recipient_email" id="recipient_email" value="{{ old('recipient_email') }}" 
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('recipient_email') border-red-500 @enderror" 
                                        placeholder="contoh@email.com">
                                    <p class="text-gray-600 text-xs mt-1">
                                        💡 <strong>Fitur Baru!</strong> Masukkan email untuk menerima notifikasi lowongan kerja yang baru dibuat
                                    </p>
                                    @error('recipient_email')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                            <a href="{{ route('jobs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

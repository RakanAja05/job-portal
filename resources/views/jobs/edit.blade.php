<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lowongan Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Lowongan *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" 
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
                                placeholder="Deskripsi pekerjaan...">{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi *</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" 
                                placeholder="Contoh: Jakarta">
                            @error('location')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="company" class="block text-gray-700 text-sm font-bold mb-2">Nama Perusahaan *</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $job->company) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('company') border-red-500 @enderror" 
                                placeholder="Contoh: PT Technology Indonesia">
                            @error('company')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Gaji (Opsional)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary', $job->salary) }}" 
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
                                    <input type="radio" name="type" value="full-time" {{ old('type', $job->type) == 'full-time' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2">Full-time</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="part-time" {{ old('type', $job->type) == 'part-time' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2">Part-time</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Logo Saat Ini</label>
                            @if($job->logo)
                                <img src="{{ asset('storage/' . $job->logo) }}" alt="Current Logo" class="h-32 w-32 object-cover mb-2">
                            @else
                                <p class="text-gray-500 text-sm">Tidak ada logo</p>
                            @endif
                        </div>

                        <div class="mb-6">
                            <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Upload Logo Baru (Opsional)</label>
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/jpg"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('logo') border-red-500 @enderror">
                            <p class="text-gray-600 text-xs mt-1">Format: JPG, PNG, JPEG. Max: 2MB. Kosongkan jika tidak ingin mengubah logo.</p>
                            @error('logo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 border-t pt-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="text-sm text-gray-600 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Pastikan semua perubahan sudah benar sebelum menyimpan.
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('jobs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded shadow transition">
                                        ✕ Batal
                                    </a>
                                    <button type="submit" onclick="return confirm('Simpan perubahan lowongan ini?')" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded shadow-lg tracking-wide flex items-center gap-2">
                                        💾 Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

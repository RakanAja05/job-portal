<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div style="margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                        <a href="{{ route('jobs.create') }}" 
                           style="display: inline-block; 
                                  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
                                  color: white; 
                                  padding: 15px 30px; 
                                  font-size: 18px; 
                                  font-weight: bold; 
                                  text-decoration: none; 
                                  border-radius: 8px; 
                                  box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            ➕ TAMBAH LOWONGAN
                        </a>

                        <a href="{{ route('jobs.export') }}" 
                           style="display: inline-block; 
                                  background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
                                  color: white; 
                                  padding: 15px 30px; 
                                  font-size: 18px; 
                                  font-weight: bold; 
                                  text-decoration: none; 
                                  border-radius: 8px; 
                                  box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            📥 EXPORT LOWONGAN (CSV)
                        </a>

                        <a href="{{ route('applications.export') }}" 
                           style="display: inline-block; 
                                  background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
                                  color: white; 
                                  padding: 15px 30px; 
                                  font-size: 18px; 
                                  font-weight: bold; 
                                  text-decoration: none; 
                                  border-radius: 8px; 
                                  box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            📥 EXPORT PELAMAR (CSV)
                        </a>

                        <button onclick="document.getElementById('importForm').style.display='block'" 
                                style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
                                       color: white; 
                                       padding: 15px 30px; 
                                       font-size: 18px; 
                                       font-weight: bold; 
                                       border: none;
                                       border-radius: 8px; 
                                       cursor: pointer;
                                       box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            📤 IMPORT CSV
                        </button>
                    </div>

                    <!-- Import Form (Hidden by default) -->
                    <div id="importForm" style="display: none; margin-bottom: 2rem; padding: 20px; background-color: #f9fafb; border-radius: 8px; border: 2px solid #7c3aed;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h3 style="font-size: 18px; font-weight: bold; color: #7c3aed;">Import Data Lowongan (Format CSV)</h3>
                            <button onclick="document.getElementById('importForm').style.display='none'" 
                                    style="background: #ef4444; color: white; padding: 5px 15px; border: none; border-radius: 4px; cursor: pointer;">
                                ✕ Tutup
                            </button>
                        </div>
                        <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                                    Pilih File CSV (format: title,company,location,description,requirements,type,salary,logo):
                                </label>
                                <input type="file" name="file" required accept=".csv,.txt"
                                       style="width: 100%; padding: 10px; border: 2px solid #d1d5db; border-radius: 6px;">
                            </div>
                            <div style="margin-top: 15px;">
                                <button type="submit" 
                                        style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
                                               color: white; 
                                               padding: 12px 30px; 
                                               font-size: 16px; 
                                               font-weight: bold; 
                                               border: none;
                                               border-radius: 6px; 
                                               cursor: pointer;
                                               box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    📤 Upload & Import
                                </button>
                            </div>
                        </form>
                        <div style="margin-top: 15px; padding: 12px; background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px;">
                            <p style="color: #92400e; font-size: 14px; margin: 0;">
                                <strong>💡 Format Excel:</strong> Pastikan file Excel memiliki kolom: title, company, location, description, requirements, type, salary, logo
                            </p>
                        </div>
                    </div>

                    <!-- Card Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($jobs as $job)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                            <!-- Logo -->
                            <div class="h-48 bg-gray-100 flex items-center justify-center">
                                @if($job->logo)
                                    <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-5">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $job->title }}</h3>
                                
                                <!-- Company -->
                                <p class="text-gray-700 font-semibold mb-1">{{ $job->company }}</p>
                                
                                <!-- Location & Type -->
                                <div class="flex items-center text-gray-600 text-sm mb-2">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $job->location }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="px-2 py-1 text-xs rounded {{ $job->type == 'full-time' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($job->type) }}
                                    </span>
                                </div>
                                
                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit($job->description, 100) }}
                                </p>
                                
                                <!-- Salary -->
                                @if($job->salary)
                                <div class="flex items-center text-green-600 font-semibold mb-4">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Rp {{ number_format($job->salary, 0, ',', '.') }}
                                </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded text-sm font-medium transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('jobs.edit', $job->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 px-4 rounded text-sm font-medium transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus lowongan ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded text-sm font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 style="margin-top: 1rem; font-size: 1.5rem; font-weight: bold; color: #111827;">
                                Belum ada lowongan kerja
                            </h3>
                            <p style="margin-top: 0.5rem; font-size: 1rem; color: #6b7280;">
                                Mulai dengan menambahkan lowongan baru
                            </p>
                            <div style="margin-top: 2rem;">
                                <a href="{{ route('jobs.create') }}" 
                                   style="display: inline-block; 
                                          background-color: #16a34a; 
                                          color: white; 
                                          padding: 20px 40px; 
                                          font-size: 20px; 
                                          font-weight: bold; 
                                          text-decoration: none; 
                                          border-radius: 10px; 
                                          box-shadow: 0 10px 15px rgba(0,0,0,0.2);">
                                    ➕ TAMBAH LOWONGAN BARU
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Lamaran Kerja') }} (Admin)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h3 class="text-2xl font-bold">📋 Daftar Semua Lamaran</h3>
                        <div style="display: flex; gap: 15px;">
                            <a href="{{ route('notifications.index') }}" 
                               style="display: inline-block; 
                                      background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
                                      color: white; 
                                      padding: 15px 30px; 
                                      font-size: 16px; 
                                      font-weight: bold; 
                                      text-decoration: none; 
                                      border-radius: 8px; 
                                      box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                🔔 NOTIFIKASI
                            </a>
                            <a href="{{ route('applications.export') }}" 
                               style="display: inline-block; 
                                      background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
                                      color: white; 
                                      padding: 15px 30px; 
                                      font-size: 16px; 
                                      font-weight: bold; 
                                      text-decoration: none; 
                                      border-radius: 8px; 
                                      box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                📥 EXPORT EXCEL
                            </a>
                        </div>
                    </div>

                    @if($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelamar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lamar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applications as $application)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            #{{ $application->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->job->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->job->location }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $application->job->company }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $application->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($application->status === 'Pending')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⏳ Pending
                                                </span>
                                            @elseif($application->status === 'Accepted')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    ✅ Diterima
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    ❌ Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($application->status === 'Pending')
                                            <div style="display: flex; gap: 5px;">
                                                <form action="{{ route('applications.accept', $application->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="background: #10b981; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px;">
                                                        ✓ Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('applications.reject', $application->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="background: #ef4444; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px;">
                                                        ✗ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                            @else
                                            <span style="color: #9ca3af; font-size: 12px;">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="margin-top: 2rem; padding: 1rem; background-color: #f3f4f6; border-radius: 8px;">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div style="font-size: 2rem; font-weight: bold; color: #f59e0b;">{{ $applications->where('status', 'Pending')->count() }}</div>
                                    <div style="color: #6b7280;">Pending</div>
                                </div>
                                <div class="text-center">
                                    <div style="font-size: 2rem; font-weight: bold; color: #10b981;">{{ $applications->where('status', 'Accepted')->count() }}</div>
                                    <div style="color: #6b7280;">Diterima</div>
                                </div>
                                <div class="text-center">
                                    <div style="font-size: 2rem; font-weight: bold; color: #ef4444;">{{ $applications->where('status', 'Rejected')->count() }}</div>
                                    <div style="color: #6b7280;">Ditolak</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada lamaran</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada data lamaran untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

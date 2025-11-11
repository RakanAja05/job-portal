<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lowongan Kerja - Job Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">💼 Job Portal</h1>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('jobs.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('applications.index') }}" class="text-gray-700 hover:text-blue-600 font-semibold">
                                Lamaran Saya
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-4">Temukan Pekerjaan Impianmu! 🚀</h1>
            <p class="text-xl mb-8">Bergabunglah dengan ribuan pencari kerja dan temukan karir terbaikmu</p>
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-2 flex">
                    <input type="text" placeholder="Cari posisi, perusahaan..." class="flex-1 px-4 py-3 text-gray-900 rounded-l-lg focus:outline-none">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-r-lg font-semibold">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-blue-600">{{ $jobs->count() }}</div>
                <div class="text-gray-600 mt-2">Lowongan Tersedia</div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-green-600">{{ $jobs->where('type', 'full-time')->count() }}</div>
                <div class="text-gray-600 mt-2">Full-Time</div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-purple-600">{{ $jobs->where('type', 'part-time')->count() }}</div>
                <div class="text-gray-600 mt-2">Part-Time</div>
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">📋 Lowongan Terbaru</h2>
        
        @if($jobs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <!-- Logo -->
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        @if($job->logo)
                            <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="h-full w-full object-cover">
                        @else
                            <div class="text-white text-6xl">🏢</div>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $job->title }}</h3>
                        <p class="text-gray-700 font-semibold mb-3">{{ $job->company }}</p>
                        
                        <div class="flex items-center text-gray-600 text-sm mb-3">
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
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($job->description, 120) }}
                        </p>
                        
                        @if($job->salary)
                        <div class="flex items-center text-green-600 font-semibold mb-4">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rp {{ number_format($job->salary, 0, ',', '.') }}
                        </div>
                        @endif
                        
                        <a href="{{ route('jobs.public.show', $job->id) }}" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-3 rounded-lg font-semibold transition-all">
                            Lihat Detail & Apply 🚀
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Lowongan</h3>
                <p class="text-gray-600">Lowongan baru akan segera hadir!</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Job Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

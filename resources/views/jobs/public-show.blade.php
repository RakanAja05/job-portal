<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Job Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">💼 Job Portal</a>
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

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Lowongan
        </a>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header with Logo -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-white">
                <div class="flex items-start gap-6">
                    @if($job->logo)
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="w-24 h-24 rounded-lg bg-white p-2">
                    @else
                        <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center text-4xl">🏢</div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold mb-2">{{ $job->title }}</h1>
                        <p class="text-2xl font-semibold mb-3">{{ $job->company }}</p>
                        <div class="flex items-center gap-4 text-lg">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $job->location }}
                            </span>
                            <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full">
                                {{ ucfirst($job->type) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="p-8">
                @if($job->salary)
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                    <div class="flex items-center text-green-700">
                        <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-bold">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                        <span class="ml-2">/ bulan</span>
                    </div>
                </div>
                @endif

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">📝 Deskripsi Pekerjaan</h2>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $job->description }}</p>
                </div>

                @if($job->requirements)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">✅ Persyaratan</h2>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $job->requirements }}</p>
                </div>
                @endif

                <div class="border-t pt-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📅 Informasi Tambahan</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-700">
                        <div>
                            <span class="font-semibold">Diposting:</span> {{ $job->created_at->diffForHumans() }}
                        </div>
                        <div>
                            <span class="font-semibold">Terakhir Update:</span> {{ $job->updated_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Apply Button -->
                <div class="mt-8 pt-6 border-t">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <div class="flex gap-4">
                                <a href="{{ route('jobs.edit', $job->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-4 rounded-lg font-bold text-lg transition-all">
                                    ✏️ Edit Lowongan
                                </a>
                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus lowongan ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-lg font-bold text-lg transition-all">
                                        🗑️ Hapus Lowongan
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('applications.create', $job->id) }}" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-4 rounded-lg font-bold text-xl transition-all shadow-lg">
                                🚀 LAMAR SEKARANG!
                            </a>
                            <p class="text-center text-gray-600 mt-4">
                                Siapkan CV Anda dalam format PDF (max 2MB)
                            </p>
                        @endif
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg">
                            <h3 class="text-xl font-bold text-yellow-800 mb-2">🔒 Login Untuk Melamar</h3>
                            <p class="text-yellow-700 mb-4">Anda harus login atau register terlebih dahulu untuk melamar pekerjaan ini.</p>
                            <div class="flex gap-4">
                                <a href="{{ route('login') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-bold transition-all">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-bold transition-all">
                                    Register
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Job Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

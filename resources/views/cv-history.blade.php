<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Analisis CV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm mb-8">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="text-xl font-bold text-gray-800">CV Analyzer</div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">
                        Selamat datang, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span>
                    </span>
                    <a href="{{ route('home') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        + Analisis Baru
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">📜 Riwayat Analisis CV Kamu</h2>

        @if ($analyses->isEmpty())
            <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-lg shadow p-6 text-center text-gray-600">
                Belum ada hasil analisis CV yang tersimpan.
            </div>
        @else
            <div class="grid gap-6 max-w-5xl mx-auto">
                @foreach ($analyses as $analysis)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 border border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $analysis->cv_filename }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $analysis->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($analysis->status === 'completed') bg-green-100 text-green-700
                                @elseif($analysis->status === 'failed') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($analysis->status) }}
                            </span>
                        </div>

                        <p class="text-gray-700 mb-4 leading-relaxed">
                            {{ Str::limit($analysis->ai_summary ?? 'Belum ada ringkasan.', 250, '...') }}
                        </p>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('cv.detail', $analysis->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                🔍 Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $analyses->links() }}
            </div>
        @endif
    </div>

</body>
</html>

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-2">Selamat datang kembali! Berikut ringkasan data Anda hari ini.</p>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('menu.create') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-blue-100 rounded-lg">
                    <i class="fas fa-utensils text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Tambah Menu</h3>
                    <p class="text-gray-500 text-sm">Buat menu baru</p>
                </div>
            </div>
        </a>

        <a href="{{ route('kategori.create') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-green-100 rounded-lg">
                    <i class="fas fa-layer-group text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Kategori Baru</h3>
                    <p class="text-gray-500 text-sm">Tambah kategori</p>
                </div>
            </div>
        </a>

        <a href="{{ route('laporan.kasir.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-purple-100 rounded-lg">
                    <i class="fas fa-file-excel text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Export Laporan</h3>
                    <p class="text-gray-500 text-sm">Unduh data</p>
                </div>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Aktivitas Kasir</h2>
                <p class="text-gray-500 text-sm mt-1">Login/Logout terbaru (WIB)</p>
            </div>
            <a href="{{ route('dashboard.kasir-aktivitas.export', ['start_date' => $startDate ?? null, 'end_date' => $endDate ?? null]) }}"
               class="px-4 py-2 text-xs font-semibold text-red-700 border border-red-600 rounded-lg hover:bg-red-50">
                Export CSV
            </a>
        </div>

        <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="text-xs text-gray-500">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Tampilkan</button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-red-600 text-red-600 rounded-lg text-sm hover:bg-red-50">Reset</a>
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Kasir</th>
                        <th class="py-2">Username</th>
                        <th class="py-2">Aksi</th>
                        <th class="py-2">Waktu</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($kasirLogs as $log)
                        <tr class="border-t">
                            <td class="py-3 font-medium">{{ $log->kasir->nama_lengkap ?? '-' }}</td>
                            <td class="py-3">{{ $log->kasir->username ?? '-' }}</td>
                            <td class="py-3">
                                @if($log->action === 'login')
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-emerald-100 text-emerald-700">Login</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-rose-100 text-rose-700">Logout</span>
                                @endif
                            </td>
                            <td class="py-3">
                                {{ $log->logged_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td class="py-4 text-gray-500" colspan="4">Belum ada aktivitas kasir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>  

    {{-- Log Aktivitas Kasir --}}

    
</div>

<style>
    body {
        overflow-x: hidden;
    }
</style>

@endsection

@push('scripts')
@endpush
  
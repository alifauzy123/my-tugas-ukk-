    @extends('layouts.layoutkasir')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Header / Welcome -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Halo,</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        {{ $kasir->nama_lengkap ?? 'Kasir' }}
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Siap melayani transaksi hari ini? Semangat!</p>
                </div>
                {{-- <div class="flex gap-3">
                    <a href="{{ route('pesanan.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 transition">
                        <i class="fas fa-plus"></i>
                        Pesanan Baru
                    </a>
                    <a href="{{ route('pembayaran.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700 transition">
                        <i class="fas fa-money-bill-wave"></i>
                        Pembayaran
                    </a>
                </div> --}}
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Omset Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($omsetHariIni, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Termasuk pembayaran sukses</p>
            </div>
            <div class="bg-white rounded-2xl border  border-gray-100 p-5 shadow-sm ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $transaksiHariIni }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Update real-time</p>
            </div>
            
            {{-- <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Antrian Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $transaksiPending }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Sedang menunggu dibuat</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Kepuasan Pelanggan</p>
                        <p class="text-2xl font-bold text-gray-800">—</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Skor dari ulasan</p>
            </div> --}}
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <!-- Left: Recent Orders -->
            <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h2>
                        <p class="text-xs text-gray-500">Ringkasan transaksi terbaru</p>
                    </div>
                    <a href="{{ route('kasir.transaksi.list') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">Lihat semua</a>
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500">
                                    <th class="py-2">Kode</th>
                                    <th class="py-2">Total</th>
                                    <th class="py-2">Tanggal</th>
                                    {{-- <th class="py-2">Status</th> --}}
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse($transaksiTerbaru as $trx)
                                    <tr class="border-t">
                                        <td class="py-3 font-medium">{{ $trx->kode_transaksi }}</td>
                                        <td class="py-3">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                        <td class="py-3">{{ $trx->tanggal?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}</td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-emerald-100 text-emerald-700">{{ $trx->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-t">
                                        <td class="py-3" colspan="4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-gray-100 text-gray-600">Belum ada data</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Actions + Tips -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl p-5 text-white shadow-sm">
                    <h3 class="text-lg font-semibold">Akses Cepat</h3>
                    <p class="text-xs text-blue-100 mt-1">Percepat pekerjaan kasir</p>
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <a href="{{ route('kasir.transaksi') }}" class="bg-white/10 hover:bg-white/20 text-sm px-3 py-2 rounded-lg text-center">
                            Buat Transaksi
                        </a>
                        <a href="{{ route('kasir.transaksi.list') }}" class="bg-white/10 hover:bg-white/20 text-sm px-3 py-2 rounded-lg text-center">
                            Daftar Transaksi
                        </a>
                        <a href="{{ route('kasir.transaksi') }}" class="bg-white/10 hover:bg-white/20 text-sm px-3 py-2 rounded-lg text-center">
                            Bayar
                        </a>
                        <a href="{{ route('kasir.transaksi.list') }}" class="bg-white/10 hover:bg-white/20 text-sm px-3 py-2 rounded-lg text-center">
                            Riwayat
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">Tips Cepat</h3>
                    <ul class="mt-3 space-y-3 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 inline-block w-2 h-2 rounded-full bg-blue-500"></span>
                            Gunakan pencarian menu di sidebar untuk akses cepat.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                            Pastikan status pembayaran “Dibayar” sebelum serah produk.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 inline-block w-2 h-2 rounded-full bg-amber-500"></span>
                            Cek detail pesanan untuk menghindari kesalahan input.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            overflow-x: hidden;
        }
    </style>

    @endsection

    {{-- @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = {
            labels: {!! json_encode($pesananChart->pluck('tanggal')) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($pesananChart->pluck('jumlah')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: true,
                tension: 0.4
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        };

        new Chart(document.getElementById('pesananChart'), config);
    </script>
    @endpush
    --}}
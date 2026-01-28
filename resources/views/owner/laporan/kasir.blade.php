@extends('layouts.layoutowner')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Kasir</h1>
                <p class="text-sm text-gray-500">Filter berdasarkan tanggal dan export ke file.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('owner.laporan.kasir.index') }}" class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="text-xs text-gray-500">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500">Kasir</label>
                <select name="kasir_id" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="all" {{ ($kasirId ?? 'all') === 'all' ? 'selected' : '' }}>Semua Kasir</option>
                    @foreach($kasirs as $k)
                        <option value="{{ $k->id }}" {{ (string)($kasirId ?? '') === (string)$k->id ? 'selected' : '' }}>
                            {{ $k->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Tampilkan</button>
                <a href="{{ route('owner.laporan.kasir.export', ['start_date' => $startDate, 'end_date' => $endDate, 'kasir_id' => $kasirId]) }}"
                   class="px-4 py-2 border border-red-600 text-red-600 rounded-lg text-sm hover:bg-red-50">Export CSV</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Per Kasir</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Kasir</th>
                        <th class="py-2">Jumlah Transaksi</th>
                        <th class="py-2">Omset</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($summary as $row)
                        <tr class="border-t">
                            <td class="py-3">{{ $row['kasir']->nama_lengkap ?? '-' }}</td>
                            <td class="py-3">{{ $row['jumlah'] }}</td>
                            <td class="py-3">Rp {{ number_format($row['omset'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="3" class="py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Kode</th>
                        <th class="py-2">Kasir</th>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Menu</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Dibayar</th>
                        <th class="py-2">Kembalian</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($transaksis as $trx)
                        <tr class="border-t">
                            <td class="py-3 font-medium">{{ $trx->kode_transaksi }}</td>
                            <td class="py-3">{{ $trx->kasir->nama_lengkap ?? '-' }}</td>
                            <td class="py-3">{{ $trx->tanggal?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="py-3">
                                <div class="text-xs text-gray-700 space-y-1">
                                    @foreach($trx->items as $item)
                                        <div>
                                            {{ $item->menu->nama_menu ?? '-' }} x{{ $item->qty }}
                                            <span class="text-gray-500">({{ $item->tipe_pesanan }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->uang_dibayar, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-emerald-100 text-emerald-700">{{ $trx->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="8" class="py-4 text-center text-gray-500">Tidak ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

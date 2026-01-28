@extends('layouts.layoutowner')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h1>
        <p class="text-sm text-gray-500">Semua transaksi kasir tampil di sini.</p>
    </div>

    <form method="GET" action="{{ route('owner.transaksi.list') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <a href="{{ route('owner.transaksi.list') }}" class="px-4 py-2 border border-red-600 text-red-600 rounded-lg text-sm hover:bg-red-50">Reset</a>
                <button type="button" id="btnDetail" class="hidden px-4 py-2 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-50">Detail</button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Kode</th>
                        <th class="py-2">Kasir</th>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Dibayar</th>
                        <th class="py-2">Kembalian</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($transaksis as $trx)
                        <tr class="border-t cursor-pointer" data-kode="{{ $trx->kode_transaksi }}" data-items='@json($trx->items->map(fn($item) => [
                            "nama" => $item->menu->nama_menu ?? "-",
                            "qty" => $item->qty,
                            "tipe" => $item->tipe_pesanan
                        ]))'>
                            <td class="py-3 font-medium text-blue-600 hover:underline">{{ $trx->kode_transaksi }}</td>
                            <td class="py-3">{{ $trx->kasir->nama_lengkap ?? '-' }}</td>
                            <td class="py-3">{{ $trx->tanggal?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="py-3">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->uang_dibayar, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-emerald-100 text-emerald-700">{{ $trx->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t">
                            <td colspan="7" class="py-6 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalDetailTransaksi" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Detail Transaksi</h2>
            <span id="detailKode" class="text-xs text-gray-500"></span>
        </div>
        <div id="detailContent" class="text-sm"></div>

        <div class="mt-4 text-right">
            <button id="btnCloseDetail" class="px-4 py-2 bg-gray-200 rounded-lg">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const btnDetail = document.getElementById('btnDetail');
    const modalDetail = document.getElementById('modalDetailTransaksi');
    const detailContent = document.getElementById('detailContent');
    const detailKode = document.getElementById('detailKode');
    const btnCloseDetail = document.getElementById('btnCloseDetail');

    function openDetailModal(items, kode) {
        detailKode.textContent = kode ? `Kode: ${kode}` : '';
        if (!items || !items.length) {
            detailContent.innerHTML = '<p class="text-gray-500">Tidak ada item.</p>';
        } else {
            let html = '<table class="w-full text-sm border">' +
                '<tr class="bg-gray-100">' +
                '<th class="p-2 border">Menu</th>' +
                '<th class="p-2 border">Qty</th>' +
                '<th class="p-2 border">Tipe</th>' +
                '</tr>';

            items.forEach(item => {
                html += `<tr>
                    <td class="p-2 border">${item.nama ?? '-'}</td>
                    <td class="p-2 border">${item.qty ?? '-'}</td>
                    <td class="p-2 border">${item.tipe ?? '-'}</td>
                </tr>`;
            });

            html += '</table>';
            detailContent.innerHTML = html;
        }

        modalDetail.classList.remove('hidden');
    }

    btnCloseDetail.addEventListener('click', () => {
        modalDetail.classList.add('hidden');
    });

    btnDetail.addEventListener('click', () => {
        const items = JSON.parse(btnDetail.getAttribute('data-items') || '[]');
        const kode = btnDetail.getAttribute('data-kode') || '';
        openDetailModal(items, kode);
    });

    document.querySelectorAll('tbody tr[data-kode]').forEach(row => {
        row.addEventListener('click', () => {
            const items = row.getAttribute('data-items') || '[]';
            const kode = row.getAttribute('data-kode') || '';

            btnDetail.setAttribute('data-items', items);
            btnDetail.setAttribute('data-kode', kode);
            btnDetail.classList.remove('hidden');
        });
    });
</script>
@endpush

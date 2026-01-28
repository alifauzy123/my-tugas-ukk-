@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h1>
        <p class="text-sm text-gray-500">Riwayat transaksi kasir akan tampil di sini.</p>
    </div>

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
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($transaksis as $trx)
                        @php
                            $receiptItems = $trx->items->map(function ($item) {
                                return [
                                    'nama' => $item->menu->nama_menu ?? '-',
                                    'qty' => (int) $item->qty,
                                    'harga' => (float) $item->harga_satuan,
                                    'subtotal' => (float) $item->subtotal,
                                    'tipe' => $item->tipe_pesanan,
                                ];
                            })->values();

                            $receiptData = [
                                'kode' => $trx->kode_transaksi,
                                'tanggal' => optional($trx->tanggal)->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-',
                                'kasir' => $trx->kasir->nama_lengkap ?? 'Kasir',
                                'items' => $receiptItems,
                                'total' => (float) $trx->total,
                                'dibayar' => (float) $trx->uang_dibayar,
                                'kembalian' => (float) $trx->kembalian,
                            ];

                            $kitchenData = [
                                'kode' => $trx->kode_transaksi,
                                'tanggal' => optional($trx->tanggal)->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-',
                                'kasir' => $trx->kasir->nama_lengkap ?? 'Kasir',
                                'items' => $receiptItems,
                            ];
                        @endphp
                        <tr class="border-t">
                            <td class="py-3 font-medium">{{ $trx->kode_transaksi }}</td>
                            <td class="py-3">{{ $trx->kasir->nama_lengkap ?? '-' }}</td>
                            <td class="py-3">{{ $trx->tanggal?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="py-3">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->uang_dibayar, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                        data-mode="pelanggan"
                                        data-receipt='@json($receiptData)'
                                        data-kitchen='@json($kitchenData)'
                                    >
                                        Print Pelanggan
                                    </button>
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 text-xs bg-amber-600 text-white rounded-lg hover:bg-amber-700"
                                        data-mode="kitchen"
                                        data-receipt='@json($receiptData)'
                                        data-kitchen='@json($kitchenData)'
                                    >
                                        Print Kitchen
                                    </button>
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 text-xs bg-emerald-600 text-white rounded-lg hover:bg-emerald-700"
                                        data-mode="both"
                                        data-receipt='@json($receiptData)'
                                        data-kitchen='@json($kitchenData)'
                                    >
                                        Print Keduanya
                                    </button>
                                </div>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('click', async (event) => {
        const button = event.target.closest('button[data-mode]');
        if (!button) return;

        const mode = button.dataset.mode;
        const receipt = JSON.parse(button.dataset.receipt || '{}');
        const kitchen = JSON.parse(button.dataset.kitchen || '{}');

        if (!window.qzPrint) {
            Swal.fire({
                title: 'Gagal cetak',
                text: 'Modul QZ Print belum tersedia.',
                icon: 'error'
            });
            return;
        }

        try {
            if (mode === 'pelanggan') {
                await window.qzPrint.printReceipt(receipt, { printerName: 'Generic / Text Only' });
            } else if (mode === 'kitchen') {
                await window.qzPrint.printKitchenReceipt(kitchen, { printerName: 'Generic / Text Only' });
            } else if (mode === 'both') {
                await window.qzPrint.printReceipt(receipt, { printerName: 'Generic / Text Only' });
                await window.qzPrint.printKitchenReceipt(kitchen, { printerName: 'Generic / Text Only' });
            }
        } catch (err) {
            Swal.fire({
                title: 'Gagal cetak',
                text: err.message || 'Tidak dapat terhubung ke QZ Tray.',
                icon: 'error',
                footer: 'Pastikan QZ Tray berjalan dan izinkan unsigned requests.'
            });
        }
    });
</script>
@endpush

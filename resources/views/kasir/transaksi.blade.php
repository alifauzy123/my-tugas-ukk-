@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Transaksi Kasir</h1>
            <p class="text-sm text-gray-500">Tambah item, atur jumlah, pilih tipe pesanan, lalu hitung pembayaran.</p>
        </div>
        <div class="text-xs text-gray-500">Kasir: <span class="font-semibold text-gray-700">{{ Auth::guard('kasir')->user()->nama_lengkap ?? 'Kasir' }}</span></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Menu List -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Menu</h2>
                    <div class="relative">
                        <label for="menuSearch" class="sr-only">Cari menu</label>
                        <i class="fas fa-search text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input id="menuSearch" name="menuSearch" type="text" placeholder="Cari menu..." class="pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div id="menuGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($menus as $menu)
                        <div class="menu-card border border-gray-100 rounded-xl p-3 hover:shadow-md transition" data-name="{{ strtolower($menu->nama_menu) }}">
                            <div class="w-full h-32 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($menu->gambar)
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                                @endif
                            </div>
                            <div class="mt-3">
                                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $menu->nama_menu }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-2">{{ $menu->deskripsi ?? '-' }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-blue-600" data-price="{{ $menu->harga }}">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    <button class="btn-add px-3 py-1.5 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                        data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->nama_menu }}"
                                        data-price="{{ $menu->harga }}">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">Menu belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Cart / Payment -->
        <div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Keranjang</h2>

                <div id="cartEmpty" class="text-sm text-gray-500 text-center py-6">Belum ada item.</div>

                <div id="cartItems" class="space-y-3"></div>

                <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Total Item</span>
                        <span id="totalQty" class="font-semibold">0</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Total Harga</span>
                        <span id="totalPrice" class="font-semibold text-blue-600">Rp 0</span>
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <div>
                        <label for="paidInput" class="text-xs text-gray-500">Uang Dibayar</label>
                        <input id="paidInput" name="paidInput" type="number" min="0" class="w-full mt-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nominal">
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Kembalian</span>
                        <span id="changeOutput" class="font-semibold">Rp 0</span>
                    </div>
                    <button id="btnCheckout" class="w-full py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@verbatim
<template id="receiptTemplate">
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Nota</title>

<style>
    @page { size: 58mm auto; margin: 4mm; }

    * { font-family: monospace; color: #000; }

    body {
        width: 58mm;
        margin: 0;
        font-size: 10px;
        line-height: 1.25;
    }

    .title {
        font-size: 13px;
        font-weight: bold;
    }

    .center { text-align: center; }
    .right { text-align: right; }
    .small { font-size: 9px; }
    .xsmall { font-size: 8px; }

    .line {
        border-top: 1px dashed #000;
        margin: 6px 0;
    }

    table { width: 100%; border-collapse: collapse; }

    /* —————————— ITEM LIST —————————— */
    .items td {
        padding: 1px 0;
        vertical-align: top;
    }

    .items .name {
        width: 32mm;
        word-break: break-word;
    }

    .items .qty {
        width: 6mm;
        text-align: right;
    }

    .items .sub {
        width: 16mm;
        text-align: right;
    }

    /* Baris tipe (Dine In / Take Away) */
    .item-type {
        padding-bottom: 2px;
        color: #444;
        font-size: 8px;
    }

    /* —————————— SUMMARY —————————— */
    .summary td {
        padding: 2px 0;
        font-size: 10px;
    }

    .summary td:last-child {
        text-align: right;
    }
</style>

</head>
<body>

    <table class="header">
        <tr><td class="center title">NOTA TRANSAKSI</td></tr>
        <tr><td class="center small">{{tanggal}}</td></tr>
        <tr><td class="center small">Kasir: {{kasir}}</td></tr>
    </table>

    <div class="line"></div>

    <!-- ITEM LIST -->
    <table class="items">
        <tbody>
            {{items}}
        </tbody>
    </table>

    <div class="line"></div>

    <!-- SUMMARY -->
    <table class="summary">
        <tr><td>Total</td><td>{{total}}</td></tr>
        <tr><td>Dibayar</td><td>{{dibayar}}</td></tr>
        <tr><td>Kembali</td><td>{{kembalian}}</td></tr>
    </table>

    <div class="line"></div>

    <div class="center small">
        Terima kasih sudah berbelanja 🙏
    </div>

    <div style="height: 18px;"></div>

</body>
</html>
</template>
@endverbatim


@endsection

@push('scripts')
<script>
    const cart = new Map();

    const formatRupiah = (value) => {
        const number = Number(value) || 0;
        return 'Rp ' + number.toLocaleString('id-ID');
    };

    const renderCart = () => {
        const cartItems = document.getElementById('cartItems');
        const cartEmpty = document.getElementById('cartEmpty');
        cartItems.innerHTML = '';

        if (cart.size === 0) {
            cartEmpty.classList.remove('hidden');
        } else {
            cartEmpty.classList.add('hidden');
        }

        let totalQty = 0;
        let totalPrice = 0;

        cart.forEach((item) => {
            totalQty += item.qty;
            totalPrice += item.qty * item.price;

            const row = document.createElement('div');
            row.className = 'border border-gray-100 rounded-lg p-3';
            row.innerHTML = `
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">${item.name}</p>
                        <p class="text-xs text-gray-500">${formatRupiah(item.price)} x ${item.qty}</p>
                    </div>
                    <button class="text-red-500 text-xs" data-action="remove" data-key="${item.key}">Hapus</button>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button class="w-7 h-7 rounded bg-gray-100" data-action="dec" data-key="${item.key}">-</button>
                        <span class="text-sm font-semibold">${item.qty}</span>
                        <button class="w-7 h-7 rounded bg-gray-100" data-action="inc" data-key="${item.key}">+</button>
                    </div>
                    <select class="text-xs border border-gray-200 rounded px-2 py-1" data-action="type" data-key="${item.key}">
                        <option value="Dine In" ${item.type === 'Dine In' ? 'selected' : ''}>Makan di tempat</option>
                        <option value="Take Away" ${item.type === 'Take Away' ? 'selected' : ''}>Dibawa pulang</option>
                    </select>
                </div>
            `;
            cartItems.appendChild(row);
        });

        document.getElementById('totalQty').textContent = totalQty;
        document.getElementById('totalPrice').textContent = formatRupiah(totalPrice);

        const paid = Number(document.getElementById('paidInput').value || 0);
        const change = paid - totalPrice;
        document.getElementById('changeOutput').textContent = formatRupiah(change > 0 ? change : 0);
    };

    document.querySelectorAll('.btn-add').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = Number(btn.dataset.price || 0);
            const type = 'Dine In';
            const key = `${id}|${type}`;

            if (cart.has(key)) {
                cart.get(key).qty += 1;
            } else {
                cart.set(key, { key, id, name, price, qty: 1, type });
            }
            renderCart();
        });
    });

    document.getElementById('cartItems').addEventListener('click', (e) => {
        const action = e.target.dataset.action;
        const key = e.target.dataset.key;
        if (!action || !key || !cart.has(key)) return;

        const item = cart.get(key);
        if (action === 'inc') item.qty += 1;
        if (action === 'dec') item.qty = Math.max(1, item.qty - 1);
        if (action === 'remove') cart.delete(key);

        renderCart();
    });

    document.getElementById('cartItems').addEventListener('change', (e) => {
        const key = e.target.dataset.key;
        if (!key || !cart.has(key)) return;
        if (e.target.dataset.action === 'type') {
            const item = cart.get(key);
            const newType = e.target.value;
            const newKey = `${item.id}|${newType}`;

            if (newKey !== key && cart.has(newKey)) {
                cart.get(newKey).qty += item.qty;
                cart.delete(key);
            } else if (newKey !== key) {
                cart.delete(key);
                item.type = newType;
                item.key = newKey;
                cart.set(newKey, item);
            }

            renderCart();
        }
    });

    document.getElementById('paidInput').addEventListener('input', renderCart);

    document.getElementById('btnCheckout').addEventListener('click', () => {
        if (cart.size === 0) {
            alert('Keranjang kosong.');
            return;
        }
        const paidValue = Number(document.getElementById('paidInput').value || 0);
        const items = Array.from(cart.values()).map((item) => ({
            id: Number(item.id),
            qty: Number(item.qty),
            type: item.type,
        }));

        Swal.fire({
            title: 'Cetak dan Simpan transaksi?',
            text: 'Pastikan data pesanan sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (!result.isConfirmed) return;

            fetch("{{ route('kasir.transaksi.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ items, paid: paidValue })
            })
            .then(async (res) => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan transaksi.');
                return data;
            })
            .then(async (data) => {
                if (data && data.receipt) {
                    await printReceipt(data.receipt);
                }
                if (data && data.kitchen_receipt) {
                    await printKitchenReceipt(data.kitchen_receipt);
                }
                cart.clear();
                document.getElementById('paidInput').value = '';
                renderCart();
                setTimeout(() => {
                    window.location.href = "{{ route('kasir.transaksi.list') }}";
                }, 500);
            })
            .catch((err) => {
                Swal.fire({
                    title: 'Gagal',
                    text: err.message || 'Gagal menyimpan transaksi.',
                    icon: 'error'
                });
            });
        });
    });

    document.getElementById('menuSearch').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.menu-card').forEach((card) => {
            const name = card.dataset.name || '';
            card.classList.toggle('hidden', !name.includes(keyword));
        });
    });

    const formatNumber = (value) => (Number(value) || 0).toLocaleString('id-ID');

    function buildReceiptHtml(receipt) {
        const itemsHtml = (receipt.items || []).map(item => {
            return `
                <tr>
                    <td class="name">${item.nama || '-'}</td>
                    <td class="qty">${item.qty}</td>
                    <td class="sub">${formatNumber(item.subtotal)}</td>
                </tr>
                <tr>
                    <td colspan="3" class="small">${item.tipe || ''}</td>
                </tr>
            `;
        }).join('') || '<tr><td colspan="3">Tidak ada item</td></tr>';

        const tpl = document.getElementById('receiptTemplate').innerHTML;
        return tpl
            .replaceAll('@{{tanggal}}', receipt.tanggal || '')
            .replaceAll('@{{kasir}}', receipt.kasir || '')
            .replaceAll('@{{items}}', itemsHtml)
            .replaceAll('@{{total}}', formatNumber(receipt.total))
            .replaceAll('@{{dibayar}}', formatNumber(receipt.dibayar))
            .replaceAll('@{{kembalian}}', formatNumber(receipt.kembalian));
    }

    async function printReceipt(receipt) {
        if (!window.qzPrint) {
            Swal.fire({
                title: 'Gagal cetak',
                text: 'Modul QZ Print belum tersedia.',
                icon: 'error'
            });
            throw new Error('QZ Print helper belum tersedia.');
        }

        try {
            await window.qzPrint.printReceipt(receipt, {
                printerName: 'Generic / Text Only'
            });
        } catch (err) {
            Swal.fire({
                title: 'Gagal cetak',
                text: err.message || 'Tidak dapat terhubung ke QZ Tray.',
                icon: 'error',
                footer: 'Pastikan QZ Tray berjalan dan izinkan unsigned requests.'
            });
            throw err;
        }
    }

    async function printKitchenReceipt(receipt) {
        if (!window.qzPrint) {
            Swal.fire({
                title: 'Gagal cetak',
                text: 'Modul QZ Print belum tersedia.',
                icon: 'error'
            });
            throw new Error('QZ Print helper belum tersedia.');
        }

        try {
            await window.qzPrint.printKitchenReceipt(receipt, {
                printerName: 'Generic / Text Only'
            });
        } catch (err) {
            Swal.fire({
                title: 'Gagal cetak (Kitchen)',
                text: err.message || 'Tidak dapat terhubung ke QZ Tray.',
                icon: 'error',
                footer: 'Pastikan QZ Tray berjalan dan izinkan unsigned requests.'
            });
            throw err;
        }
    }

    renderCart();
</script>
@endpush

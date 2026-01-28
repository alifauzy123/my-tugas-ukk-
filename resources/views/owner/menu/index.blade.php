@extends('layouts.layoutowner')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Menu</h1>
        {{-- <span class="text-sm text-gray-500">History harga saja</span> --}}
    </div>

    @if ($menus->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <p>Belum ada menu.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-200">
                    @if ($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-gray-600 text-4xl"></i>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $menu->nama_menu }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($menu->deskripsi, 100) }}</p>

                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $menu->kategori->nama_kategori ?? 'N/A' }}</span>
                            <span class="text-sm font-bold text-red-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $menu->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($menu->status) }}
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <button type="button"
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-3 rounded text-sm transition duration-200 btn-history-harga-menu"
                                data-id="{{ $menu->id }}">
                                <i class="fas fa-history mr-1"></i>History Harga
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div id="modalHistoryHargaMenu" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Riwayat Harga Menu</h2>
        <div id="historyHargaMenuContent" class="text-sm"></div>

        <div class="mt-4 text-right">
            <button onclick="closeMenuModal('modalHistoryHargaMenu')" class="px-4 py-2 bg-gray-200 rounded-lg">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openMenuModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeMenuModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID').format(value);
}

function openMenuHistoryHarga(id) {
    openMenuModal('modalHistoryHargaMenu');
    document.getElementById('historyHargaMenuContent').innerHTML = '<p class="text-gray-500">Memuat data...</p>';

    fetch(`/owner/menu/${id}/history-harga`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                document.getElementById('historyHargaMenuContent').innerHTML = '<p class="text-gray-500">Belum ada riwayat harga.</p>';
                return;
            }

            let html = `
                <table class="w-full text-sm border">
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Harga Lama</th>
                        <th class="p-2 border">Harga Baru</th>
                        <th class="p-2 border">Tanggal</th>
                    </tr>
            `;

            data.forEach(r => {
                html += `
                    <tr>
                        <td class="p-2 border">Rp ${formatRupiah(r.harga_lama)}</td>
                        <td class="p-2 border">Rp ${formatRupiah(r.harga_baru)}</td>
                        <td class="p-2 border">${new Date(r.created_at).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            });

            html += '</table>';
            document.getElementById('historyHargaMenuContent').innerHTML = html;
        });
}

document.querySelectorAll('.btn-history-harga-menu').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        openMenuHistoryHarga(id);
    });
});
</script>
@endpush

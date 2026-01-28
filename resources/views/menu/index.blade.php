@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Menu</h1>
        <a href="{{ route('menu.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Menu
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($menus->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <p>Belum ada menu. <a href="{{ route('menu.create') }}" class="font-bold underline">Tambah menu baru</a></p>
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
                            <a href="{{ route('menu.edit', $menu) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 rounded text-center text-sm transition duration-200">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('menu.destroy', $menu) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm transition duration-200">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>

                        <div class="flex gap-2 mt-2">
                            <button type="button"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded text-sm transition duration-200 btn-edit-harga-menu"
                                data-id="{{ $menu->id }}"
                                data-nama="{{ $menu->nama_menu }}"
                                data-harga="{{ $menu->harga }}">
                                <i class="fas fa-dollar-sign mr-1"></i>Edit Harga
                            </button>
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

<div id="modalEditHargaMenu" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-lg font-semibold mb-2">Edit Harga Menu</h2>
        <p class="text-sm text-gray-600 mb-4" id="editHargaMenuNama"></p>

        <form id="formEditHargaMenu">
            @csrf
            <input type="hidden" id="editHargaMenuId">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="editHargaMenuInput">Harga Baru (Rp)</label>
                <input type="number" id="editHargaMenuInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" min="0" step="1000" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeMenuModal('modalEditHargaMenu')" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
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

function openMenuEditHarga(id, nama, harga) {
    document.getElementById('editHargaMenuId').value = id;
    document.getElementById('editHargaMenuNama').textContent = nama;
    document.getElementById('editHargaMenuInput').value = harga;
    openMenuModal('modalEditHargaMenu');
}

function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID').format(value);
}

function openMenuHistoryHarga(id) {
    openMenuModal('modalHistoryHargaMenu');
    document.getElementById('historyHargaMenuContent').innerHTML = '<p class="text-gray-500">Memuat data...</p>';

    fetch(`/menu/${id}/history-harga`)
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

document.querySelectorAll('.btn-edit-harga-menu').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const harga = btn.getAttribute('data-harga');
        openMenuEditHarga(id, nama, harga);
    });
});

document.querySelectorAll('.btn-history-harga-menu').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        openMenuHistoryHarga(id);
    });
});

document.getElementById('formEditHargaMenu').addEventListener('submit', async function(event) {
    event.preventDefault();

    const id = document.getElementById('editHargaMenuId').value;
    const hargaBaru = document.getElementById('editHargaMenuInput').value;

    const response = await fetch(`/menu/${id}/edit-harga`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ harga_baru: hargaBaru })
    });

    const result = await response.json();

    if (result.success) {
        closeMenuModal('modalEditHargaMenu');
        Swal.fire('Berhasil', 'Harga menu berhasil diperbarui!', 'success').then(() => location.reload());
    } else {
        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data', 'error');
    }
});
</script>
@endpush

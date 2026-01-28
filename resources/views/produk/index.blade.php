@extends('layouts.app')

@section('content')

<style>
    /* Biar modal tidak terlalu tinggi */
    .modal-body-scroll {
        max-height: 70vh;        /* modal dibatasi 70% tinggi layar */
        overflow-y: auto;        /* isi bisa discroll */
    }
</style>

<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box-open text-white text-lg"></i>
                </div>
                Master Data Produk
            </h1>
            <p class="text-gray-500 mt-2">Kelola semua data produk dengan mudah</p>
        </div>
        <a href="{{ route('produk.create') }}" 
            class="flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-plus"></i>
            <span class="font-semibold">Tambah Produk</span>
        </a>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="md:col-span-2">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fas fa-search text-lg"></i>
            </span>
            <input type="text" id="search" placeholder="Cari produk berdasarkan nama, kode, kategori..." 
                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
        </div>
    </div>
    <div class="flex gap-2">
        <select id="filterStatus" class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 text-sm">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
        <button onclick="refreshTable()" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all text-sm font-semibold border-2 border-gray-200">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Produk</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($produk) }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Produk Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ count(array_filter($produk->toArray(), fn($p) => strtolower($p['status']) === 'aktif')) }}
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Nonaktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ count(array_filter($produk->toArray(), fn($p) => strtolower($p['status']) !== 'aktif')) }}
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <p class="text-white font-semibold text-sm">DAFTAR PRODUK</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 w-12 text-left font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Produk</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Harga</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Stok</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody id="dataTable">
                @forelse($produk as $index => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 data-row">
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $index + 1 }}</td>

                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $row->kode_produk }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $row->nama_produk }}</td>

                        <td class="px-6 py-4 text-gray-700 text-sm">
                            {{ $row->kategori->nama_kategori ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-semibold">
                            Rp {{ number_format($row->harga, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">{{ $row->stok }}</td>

                        <td class="px-6 py-4 text-center">
                            @if(strtolower($row->status) === 'aktif')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>

                       <td class="px-6 py-4 text-center flex justify-center gap-2">

    <!-- Lihat / Detail -->
    <button onclick="goShow({{ $row->id }})"
        class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
        <i class="fas fa-eye"></i>
    </button>

    <!-- Edit -->
    <button onclick="goEdit({{ $row->id }})"
        class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
        <i class="fas fa-pen"></i>
    </button>

    <!-- Edit Harga -->
    <button onclick="openEditHarga({{ $row->id }}, '{{ $row->kode_produk }}', '{{ $row->nama_produk }}', '{{ $row->harga }}')"
        class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
        <i class="fas fa-dollar-sign"></i>
    </button>

    <!-- History Harga -->
    <button onclick="openHistoryHarga({{ $row->id }})"
        class="px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200">
        <i class="fas fa-history"></i>
    </button>

    <!-- Mutasi Stok -->
    <button onclick="openHistoryStok({{ $row->id }})"
        class="px-3 py-1 bg-orange-100 text-orange-700 rounded hover:bg-orange-200">
        <i class="fas fa-boxes"></i>
    </button>

    <!-- Delete -->
    <button onclick="deleteProduk({{ $row->id }})"
        class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
        <i class="fas fa-trash"></i>
    </button>

</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-semibold">Belum ada produk</p>
                                <p class="text-gray-400 text-sm mt-1">Klik "Tambah Produk" untuk membuat produk baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<div id="modalEditHarga" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Edit Harga</h2>

        <form id="formEditHarga">
            @csrf
            <input type="hidden" id="edit_id">

            <div class="mb-3">
                <label>Kode Produk</label>
                <input id="edit_kode" class="w-full border p-2 bg-gray-100 rounded" readonly>
            </div>

            <div class="mb-3">
                <label>Nama Produk</label>
                <input id="edit_nama" class="w-full border p-2 bg-gray-100 rounded" readonly>
            </div>

            <div class="mb-3">
                <label>Harga Baru</label>
                <input id="edit_harga" name="harga_baru" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalEditHarga')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="modalHistoryHarga" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Riwayat Harga</h2>
        <div id="historyHargaContent" class="text-sm"></div>

        <div class="mt-4 text-right">
            <button onclick="closeModal('modalHistoryHarga')" class="px-4 py-2 bg-gray-300 rounded">Tutup</button>
        </div>
    </div>
</div>


<div id="modalHistoryStok" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-11/12 md:w-2/3 lg:w-1/2 rounded shadow-lg">
        
        <div class="p-4 border-b flex justify-between">
            <h2 class="text-lg font-bold">History Stok</h2>
            <button onclick="closeModal('modalHistoryStok')" class="text-red-600 font-bold">X</button>
        </div>

        <div class="p-4 modal-body-scroll" id="historyStokContent">
            loading...
        </div>

    </div>
</div>



@endsection

@push('scripts')
<script>
    document.getElementById('search').addEventListener('input', function () {
        const key = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(key) ? '' : 'none';
        });
    });

    document.getElementById('filterStatus').addEventListener('change', function () {
        const selected = this.value.toLowerCase();

        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const status = row.children[6].innerText.toLowerCase();
            row.style.display = selected === '' || status.includes(selected) ? '' : 'none';
        });
    });

    function refreshTable() { location.reload(); }

    function deleteProduk(id) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: 'Data yang dihapus tidak dapat dipulihkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/produk/${id}`;

                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // ========== FUNGSI BUKA & TUTUP MODAL ==========
function openModal(id) {
    document.getElementById(id).classList.remove("hidden");
}
function closeModal(id) {
    document.getElementById(id).classList.add("hidden");
}



// ===================================================
//                EDIT HARGA
// ===================================================
function openEditHarga(id, kode, nama, harga) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_kode').value = kode;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_harga').value = harga;

    openModal('modalEditHarga');
}

// Submit Edit Harga
document.getElementById("formEditHarga").addEventListener("submit", async function(event) {
    event.preventDefault();

    const id = document.getElementById('edit_id').value;
    const hargaBaru = document.getElementById('edit_harga').value;

    const response = await fetch(`/produk/${id}/edit-harga`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ harga_baru: hargaBaru })
    });

    const result = await response.json();

    if (result.success) {
        Swal.fire("Berhasil", "Harga berhasil diperbarui!", "success")
            .then(() => location.reload());
    } else {
        Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan data", "error");
    }
});





// ===================================================
//                 HISTORY HARGA
// ===================================================
function openHistoryHarga(id) {
    openModal("modalHistoryHarga");

    document.getElementById("historyHargaContent").innerHTML = `
        <p class="text-gray-500">Memuat data...</p>
    `;

    fetch(`/produk/${id}/history-harga`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                document.getElementById("historyHargaContent").innerHTML =
                    `<p class="text-gray-500">Belum ada riwayat harga.</p>`;
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
                        <td class="p-2 border">${formatTanggal(r.created_at)}</td>
                    </tr>
                `;
            });

            html += "</table>";
            document.getElementById("historyHargaContent").innerHTML = html;
        });
}





// ===================================================
//                 HISTORY MUTASI STOK
// ===================================================
function openHistoryStok(id) {
    openModal("modalHistoryStok");

    document.getElementById("historyStokContent").innerHTML =
        `<p class="text-gray-500">Memuat data...</p>`;

    fetch(`/produk/${id}/history-stok`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                document.getElementById("historyStokContent").innerHTML =
                    `<p class="text-gray-500">Belum ada mutasi stok.</p>`;
                return;
            }

            let html = `
                <table class="w-full text-sm border">
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Jenis</th>
                        <th class="p-2 border">Qty</th>
                        <th class="p-2 border">Stok Sebelum</th>
                        <th class="p-2 border">Stok Sesudah</th>
                        <th class="p-2 border">Keterangan</th>
                        <th class="p-2 border">Tanggal</th>
                    </tr>
            `;

            data.forEach(r => {
                html += `
                    <tr>
                        <td class="p-2 border">${r.jenis_mutasi}</td>
                        <td class="p-2 border">${r.qty_mutasi}</td>
                        <td class="p-2 border">${r.stok_sebelum}</td>
                        <td class="p-2 border">${r.stok_sesudah}</td>
                        <td class="p-2 border">${r.keterangan ?? "-"}</td>
                        <td class="p-2 border">${formatTanggal(r.created_at)}</td>
                    </tr>
                `;
            });

            html += `</table>`;
            document.getElementById("historyStokContent").innerHTML = html;
        });
}



// ===================================================
//                    DELETE PRODUK
// ===================================================
function deleteProduk(id) {
    Swal.fire({
        title: "Hapus Produk?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal"
    }).then(result => {
        if (result.isConfirmed) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = `/produk/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}



// ===================================================
//           NAVIGASI READ / EDIT
// ===================================================
function goShow(id) {
    window.location.href = `/produk/${id}`;
}

function goEdit(id) {
    window.location.href = `/produk/${id}/edit`;
}



// ===================================================
//           FUNGSI FORMAT TANGGAL & RUPIAH
// ===================================================
function formatTanggal(tgl) {
    const d = new Date(tgl);
    return d.toLocaleString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
    });
}

function formatRupiah(angka) {
    return new Intl.NumberFormat("id-ID").format(angka);
}
</script>
@endpush

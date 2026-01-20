@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700 relative">

    {{-- Header --}}
     <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="search" placeholder="Telusuri..." 
                class="pl-9 pr-3 py-1.5 border-2 border-gray-400 rounded-md w-full focus:outline-none text-sm">
        </div>
        <button id="btnRead" class="hidden px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm" title="View">
            <i class="fas fa-eye"></i>
        </button>
        <button id="btnEdit" class="hidden px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm" title="Edit">
            <i class="fas fa-pen"></i>
        </button>
        <button id="btnDelete" class="hidden px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
        <button id="btnEditHarga" class="hidden px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 text-sm" title="Edit Harga">
            <i class="fas fa-dollar-sign"></i>
        </button>
        <button id="btnHistoryHarga" class="hidden px-2 py-1 bg-purple-100 text-purple-800 rounded-md hover:bg-purple-200 text-sm" title="Riwayat Harga">
            <i class="fas fa-history"></i>
        </button>
        <button id="btnHistoryStok" class="hidden px-2 py-1 bg-orange-100 text-orange-800 rounded-md hover:bg-orange-200 text-sm" title="Riwayat Stok">
            <i class="fas fa-boxes"></i>
        </button>

    </div>


        {{-- Jumlah data + Refresh + Create --}}
        <div class="flex items-center gap-2" id="aksiButtons">
            <a href="{{ route('produk.create') }}" class="bg-white border-2 border-red-700 text-red-700 px-4 py-2 rounded-md hover:bg-red-700 hover:text-white text-sm">
                + Create New
            </a>
            <button onclick="refreshTable()" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>
    {{-- Tabel --}}
    <table class="w-full text-sm border-2 border-gray-400 rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border-2 border-gray-300">No</th>
                <th class="px-4 py-2 border-2 border-gray-300">Kode</th>
                <th class="px-4 py-2 border-2 border-gray-300">Nama</th>
                <th class="px-4 py-2 border-2 border-gray-300">Kategori</th>
                <th class="px-4 py-2 border-2 border-gray-300">Harga</th>
                <th class="px-4 py-2 border-2 border-gray-300">Stok</th>
                <th class="px-4 py-2 border-2 border-gray-300">Status</th>
            </tr>
        </thead>
        <tbody id="dataTable">
            @foreach ($produk as $p)
            <tr onclick="selectRow(this)" data-id="{{ $p->id }}" class="bg-white hover:bg-yellow-100 cursor-pointer">
                <td class="px-4 py-2 border-2 border-gray-200">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $p->kode_produk }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $p->nama_produk }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $p->stok }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $p->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- Modal Edit Harga --}}
<div id="modalEditHarga" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">Edit Harga</h2>
        <form id="formEditHarga">
            @csrf
            <input type="hidden" name="produk_id" id="produk_id_edit">
            <div class="mb-3">
                <label>Kode Produk</label>
                <input type="text" id="kode_produk_edit" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" id="nama_produk_edit" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div class="mb-3">
                <label>Harga Baru</label>
                <input type="number" name="harga_baru" id="harga_baru_edit" class="w-full border rounded p-2" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="tutupModalHarga()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalHistoryStok" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Riwayat Mutasi Stok</h2>
        <div id="historyStokContent" class="text-sm"></div>
        <div class="mt-4 text-right">
            <button onclick="tutupModalHistoryStok()" class="px-4 py-2 bg-gray-300 rounded">Tutup</button>
        </div>
    </div>
</div>


<div id="modalHistoryHarga" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md w-full max-w-lg">
        <h2 class="text-lg font-semibold mb-4">Riwayat Harga</h2>
        <div id="historyHargaContent" class="text-sm"></div>
        <div class="mt-4 text-right">
            <button onclick="tutupModalHistory()" class="px-4 py-2 bg-gray-300 rounded">Tutup</button>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    let selectedId = null;
    let selectedRow = null;

    function selectRow(row) {
        document.querySelectorAll('#dataTable tr').forEach(r => r.classList.remove('bg-gray-100'));
        row.classList.add('bg-gray-100');
        selectedId = row.getAttribute('data-id');
        selectedRow = row;
        ['btnRead', 'btnEdit', 'btnDelete', 'btnEditHarga', 'btnHistoryHarga', 'btnHistoryStok'].forEach(id => document.getElementById(id).classList.remove('hidden'));
    }

    document.addEventListener('click', function (e) {
        const isOutsideClick = !document.getElementById('dataTable').contains(e.target) &&
            !e.target.closest('#btnRead') &&
            !e.target.closest('#btnEdit') &&
            !e.target.closest('#btnEditHarga') &&
            !e.target.closest('#btnHistoryStok') &&
            !e.target.closest('#btnDelete');

        if (isOutsideClick) {
            selectedId = null;
            if (selectedRow) selectedRow.classList.remove('bg-gray-100');
            ['btnRead', 'btnEdit', 'btnDelete', 'btnEditHarga', 'btnHistoryHarga', 'btnHistoryStok'].forEach(id => document.getElementById(id).classList.add('hidden'));
        }
    });

    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr').forEach(row => {
            const content = row.innerText.toLowerCase();
            row.style.display = content.includes(keyword) ? '' : 'none';
        });
    });

    // ✅ Tombol DELETE pakai FORM agar bisa pakai method DELETE (bukan GET)
    document.getElementById('btnDelete').addEventListener('click', () => {
    if (selectedId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/produk/${selectedId}`;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
});



    // ✅ Tombol READ
    document.getElementById('btnRead').addEventListener('click', () => {
        if (selectedId) window.location.href = `/produk/${selectedId}`;
    });

    // ✅ Tombol EDIT
    document.getElementById('btnEdit').addEventListener('click', () => {
        if (selectedId) window.location.href = `/produk/${selectedId}/edit`;
    });

    // 🔍 Pencarian
    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });

    // 🔁 Refresh
    function refreshTable() {
        window.location.reload();
    }

    // Tambahkan ke array visible buttons
    ['btnRead', 'btnEdit', 'btnDelete', 'btnEditHarga', 'btnHistoryHarga', 'btnHistoryStok'].forEach(id => {
        if (document.getElementById(id)) {
            document.getElementById(id).classList.add('hidden');
        }
    });

    document.getElementById('btnEditHarga').addEventListener('click', async () => {
        if (selectedRow) {
            const id = selectedId;
            document.getElementById('produk_id_edit').value = id;
            document.getElementById('kode_produk_edit').value = selectedRow.children[1].innerText;
            document.getElementById('nama_produk_edit').value = selectedRow.children[2].innerText;
            document.getElementById('harga_baru_edit').value = selectedRow.children[4].innerText.replace(/\D/g, '');
            document.getElementById('modalEditHarga').classList.remove('hidden');
        }
    });

    function tutupModalHarga() {
        document.getElementById('modalEditHarga').classList.add('hidden');
    }

    document.getElementById('formEditHarga').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('produk_id_edit').value;
        const harga = document.getElementById('harga_baru_edit').value;
        fetch(`/produk/${id}/edit-harga`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({ harga_baru: harga })
})
.then(res => res.json()) // ⬅️ penting! parse JSON dulu
.then(data => {
    if (data.success) {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Harga berhasil diperbarui!',
            timer: 1500,
            showConfirmButton: false
        });
        tutupModalHarga();
        setTimeout(() => {
            refreshTable();
        }, 1600);
    }
})
.catch(error => {
    console.error('Gagal update harga:', error);
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Terjadi kesalahan saat memperbarui harga.',
    });
});

    });
  
    document.getElementById('btnHistoryHarga').addEventListener('click', async () => {
        const id = selectedId;
        const res = await fetch(`/produk/${id}/history-harga`);
        const data = await res.json();

        let html = '';
        if (data.length > 0) {
            html += '<table class="w-full border text-sm"><thead><tr><th>Harga Lama</th><th>Harga Baru</th><th>Tanggal</th></tr></thead><tbody>';
            data.forEach(item => {
                html += `<tr>
                    <td>Rp ${parseInt(item.harga_lama).toLocaleString('id-ID')}</td>
                    <td>Rp ${parseInt(item.harga_baru).toLocaleString('id-ID')}</td>
                    <td>${formatTanggal(item.created_at)}</td>
                </tr>`;
            });
            html += '</tbody></table>';
        } else {
            html = '<p>Belum ada riwayat harga.</p>';
        }

        document.getElementById('historyHargaContent').innerHTML = html;
        document.getElementById('modalHistoryHarga').classList.remove('hidden');
    });

    function tutupModalHistory() {
        document.getElementById('modalHistoryHarga').classList.add('hidden');
    }
    function formatTanggal(tanggal) {
    const t = new Date(tanggal);
    const options = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return t.toLocaleString('id-ID', options).replace('.', ':');
}

document.getElementById('btnHistoryStok').addEventListener('click', async () => {
    const id = selectedId;
    const res = await fetch(`/produk/${id}/history-stok`);
    const data = await res.json();

    let html = '';
    if (data.length > 0) {
        html += `
            <table class="w-full border text-sm">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.forEach(item => {
            html += `
                <tr>
                    <td>${item.jenis_mutasi}</td>
                    <td>${item.qty_mutasi}</td>
                    <td>${item.stok_sebelum}</td>
                    <td>${item.stok_sesudah}</td>
                    <td>${item.keterangan ?? '-'}</td>
                    <td>${formatTanggal(item.created_at)}</td>
                </tr>
            `;
        });

        html += `</tbody></table>`;
    } else {
        html = '<p>Belum ada mutasi stok.</p>';
    }

    document.getElementById('historyStokContent').innerHTML = html;
    document.getElementById('modalHistoryStok').classList.remove('hidden');
});


function tutupModalHistoryStok() {
    document.getElementById('modalHistoryStok').classList.add('hidden');
}
        const statusMatch = statusValue === '' || status.includes(statusValue);

        row.style.display = (searchMatch && statusMatch) ? '' : 'none';
    });
}
</script>
@endpush

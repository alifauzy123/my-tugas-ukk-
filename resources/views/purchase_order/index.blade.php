@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700 relative">

    {{-- Search + Aksi --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center gap-2 w-full md:w-auto">

            {{-- Search --}}
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="search" placeholder="Telusuri..."
                    class="pl-9 pr-3 py-1.5 border-2 border-gray-400 rounded-md w-full focus:outline-none text-sm">
            </div>

            {{-- Aksi Buttons --}}
            <button id="btnRead" class="hidden px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm" title="View">
                <i class="fas fa-eye"></i>
            </button>
            <button id="btnEdit" class="hidden px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm" title="Edit">
                <i class="fas fa-pen"></i>
            </button>
            <button id="btnDelete" class="hidden px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        {{-- Create + Refresh --}}
        <div class="flex items-center gap-2" id="aksiButtons">
            <a href="{{ route('purchase_order.create') }}"
                class="bg-white border-2 border-red-700 text-red-700 px-4 py-2 rounded-md hover:bg-red-700 hover:text-white text-sm">
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
        <th class="px-4 py-2 border-2 border-gray-300">Kode PO</th>
        <th class="px-4 py-2 border-2 border-gray-300">Kategori</th>
        <th class="px-4 py-2 border-2 border-gray-300">Nama Produk</th>
        <th class="px-4 py-2 border-2 border-gray-300">Harga</th>
        <th class="px-4 py-2 border-2 border-gray-300">Jumlah</th>

        {{-- Baru --}}
        <th class="px-4 py-2 border-2 border-gray-300">DP</th>
        <th class="px-4 py-2 border-2 border-gray-300">Diskon</th>
        <th class="px-4 py-2 border-2 border-gray-300">Subtotal</th>

        <th class="px-4 py-2 border-2 border-gray-300">Status</th>
    </tr>
</thead>

<tbody id="dataTable">
    @forelse ($data as $index => $row)
        <tr class="bg-white hover:bg-yellow-100 cursor-pointer"
            onclick="selectRow(this)" data-id="{{ $row->id }}">

            <td class="px-4 py-2 border-2 border-gray-200">{{ $index + 1 }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">{{ $row->kode_po }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">{{ $row->kategori->nama_kategori }}</td>

            <td class="px-4 py-2 border-2 border-gray-200">{{ $row->nama_produk }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">Rp {{ number_format($row->harga_produk) }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">{{ $row->jumlah }}</td>

            {{-- Baru --}}
            <td class="px-4 py-2 border-2 border-gray-200">Rp {{ number_format($row->dp) }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">Rp {{ number_format($row->diskon) }}</td>
            <td class="px-4 py-2 border-2 border-gray-200">Rp {{ number_format($row->subtotal) }}</td>

            <td class="px-4 py-2 border-2 border-gray-200">
    @if ($row->status === 'aktif')
        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">
            Aktif
        </span>
    @else
        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">
            Nonaktif
        </span>
    @endif
</td>

        </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center py-3">Data tidak tersedia.</td>
        </tr>
    @endforelse
</tbody>

    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>

{{-- Form Hapus --}}
<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
        ['btnRead', 'btnEdit', 'btnDelete'].forEach(id => document.getElementById(id).classList.remove('hidden'));
    }

    document.addEventListener('click', function(e) {
        const isOutside = !document.getElementById('dataTable').contains(e.target);
        const isBtn = e.target.closest('#btnRead') || e.target.closest('#btnEdit') || e.target.closest('#btnDelete');

        if (isOutside && !isBtn) {
            selectedId = null;
            if (selectedRow) selectedRow.classList.remove('bg-gray-100');
            ['btnRead', 'btnEdit', 'btnDelete'].forEach(id => document.getElementById(id).classList.add('hidden'));
        }
    });

    document.getElementById('btnRead').addEventListener('click', () => {
        if (selectedId) window.location.href = `/purchase_order/${selectedId}`;
    });

    document.getElementById('btnEdit').addEventListener('click', () => {
        if (selectedId) window.location.href = `/purchase_order/${selectedId}/edit`;
    });

    document.getElementById('btnDelete').addEventListener('click', () => {

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: 'No'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('formDelete');
                form.action = `/purchase_order/${selectedId}`;
                form.submit();
            }
        });

    });

    function refreshTable() {
        location.reload();
    }
</script>
@endpush

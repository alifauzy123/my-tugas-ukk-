@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-white text-lg"></i>
                </div>
                Purchase Order
            </h1>
            <p class="text-gray-500 mt-2">Kelola semua purchase order dengan mudah</p>
        </div>

        <a href="{{ route('purchase_order.create') }}"
            class="flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-plus"></i>
            <span class="font-semibold">Tambah PO Baru</span>
        </a>
    </div>
</div>

<!-- Search & Refresh -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="md:col-span-2">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fas fa-search text-lg"></i>
            </span>
            <input type="text" id="search" placeholder="Cari berdasarkan kode, kategori, atau produk..."
                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm">
        </div>
    </div>

    <div class="flex gap-2 items-center">
        <button onclick="refreshTable()"
            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all text-sm font-semibold border-2 border-gray-200">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total PO</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $data->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-red-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">PO Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $data->filter(fn($row) => $row->status === 'aktif')->count() }}
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
                <p class="text-gray-500 text-sm font-semibold">PO Nonaktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    {{ $data->filter(fn($row) => $row->status !== 'aktif')->count() }}
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>

</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">

    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <p class="text-white font-semibold text-sm">DAFTAR PURCHASE ORDER</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode PO</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Produk</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Harga</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Jumlah</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">DP</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Diskon</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Subtotal</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>

            <tbody id="dataTable">
                @forelse ($data as $index => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all data-row">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $row->kode_po }}</td>
                        <td class="px-6 py-4">{{ $row->kategori->nama_kategori }}</td>
                        <td class="px-6 py-4">{{ $row->nama_produk }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($row->harga_produk) }}</td>
                        <td class="px-6 py-4">{{ $row->jumlah }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($row->dp) }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($row->diskon) }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($row->subtotal) }}</td>

                        <td class="px-6 py-4 text-center">
                            @if ($row->status === 'aktif')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('purchase_order.show', $row->id) }}"
                                    class="bg-blue-100 hover:bg-blue-500 text-blue-700 hover:text-white p-2 rounded-lg">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>

                                <a href="{{ route('purchase_order.edit', $row->id) }}"
                                    class="bg-yellow-100 hover:bg-yellow-500 text-yellow-700 hover:text-white p-2 rounded-lg">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <button onclick="deleteData({{ $row->id }})"
                                    class="bg-red-100 hover:bg-red-500 text-red-700 hover:text-white p-2 rounded-lg">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="font-semibold">Belum ada purchase order</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Form delete --}}
<form id="formDelete" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const content = row.innerText.toLowerCase();
            row.style.display = content.includes(keyword) ? '' : 'none';
        });
    });

    function refreshTable() {
        location.reload();
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Hapus PO?',
            text: 'Data yang dihapus tidak dapat dipulihkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formDelete');
                form.action = `/purchase_order/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush

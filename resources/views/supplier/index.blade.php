@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-truck text-white text-lg"></i>
                </div>
                Master Supplier
            </h1>
            <p class="text-gray-500 mt-2">Kelola semua data supplier dengan mudah</p>
        </div>
        <a href="{{ route('supplier.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-3 rounded-lg hover:from-amber-600 hover:to-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-plus"></i>
            <span class="font-semibold">Tambah Supplier</span>
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
            <input type="text" id="search" placeholder="Cari supplier berdasarkan nama, kode, atau telepon..." 
                
                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all text-sm">
        </div>
    </div>
    <div class="flex gap-2">
        <select id="filterStatus" class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-amber-500 text-sm">
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
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-amber-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Supplier</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($supplier) }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-truck text-amber-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $supplier->where('status', 'Aktif')->count() }}</p>
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
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $supplier->where('status', '!=', 'Aktif')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <p class="text-white font-semibold text-sm">DAFTAR SUPPLIER</p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left font-semibold text-gray-700 w-12">No</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Supplier</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Telepon</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Alamat</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                @forelse ($supplier as $index => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 data-row" data-id="{{ $row->id }}">
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $row->kode_supplier }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $row->nama_supplier }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $row->telepon ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($row->alamat, 40) ?? '-' }}</td>
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
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('supplier.show', $row->id) }}" class="bg-blue-100 hover:bg-blue-500 text-blue-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('supplier.edit', $row->id) }}" class="bg-yellow-100 hover:bg-yellow-500 text-yellow-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteSupplier({{ $row->id }})" class="bg-red-100 hover:bg-red-500 text-red-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-semibold">Belum ada supplier</p>
                                <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Supplier" untuk membuat supplier baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Form DELETE --}}
<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    function deleteSupplier(id) {
        Swal.fire({
            title: 'Hapus Supplier?',
            text: 'Data supplier akan dihapus dan tidak dapat dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200',
                cancelButton: 'px-6 py-2 rounded-lg font-semibold transition-all duration-200'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formDelete').action = '{{ route("supplier.destroy", ":id") }}'.replace(':id', id);
                document.getElementById('formDelete').submit();
            }
        });
    }

    function refreshTable() {
        location.reload();
    }

    // Search functionality
    document.getElementById('search').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.data-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Filter functionality
    document.getElementById('filterStatus').addEventListener('change', function() {
        const statusValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.data-row');
        
        rows.forEach(row => {
            if (!statusValue) {
                row.style.display = '';
            } else {
                const statusCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                row.style.display = statusCell.includes(statusValue) ? '' : 'none';
            }
        });
@endpush

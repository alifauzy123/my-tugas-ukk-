@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-white text-lg"></i>
                </div>
                Master Kategori Produk
            </h1>
            <p class="text-gray-500 mt-2">Kelola semua kategori produk dengan mudah</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-plus"></i>
            <span class="font-semibold">Tambah Kategori</span>
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
            <input type="text" id="search" placeholder="Cari kategori berdasarkan nama, kode, atau deskripsi..." 
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
                <p class="text-gray-500 text-sm font-semibold">Total Kategori</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($kategori) }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count(array_filter($kategori->toArray(), fn($k) => strtolower($k['status']) === 'aktif')) }}</p>
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
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count(array_filter($kategori->toArray(), fn($k) => strtolower($k['status']) !== 'aktif')) }}</p>
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
        <p class="text-white font-semibold text-sm">DAFTAR KATEGORI</p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left font-semibold text-gray-700 w-12">No</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Kategori</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Deskripsi</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                @forelse ($kategori as $index => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 data-row" data-id="{{ $row->id }}">
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $row->kode_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $row->nama_kategori }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($row->deskripsi, 40) ?? '-' }}</td>
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
                                <a href="{{ route('kategori.show', $row->id) }}" class="bg-blue-100 hover:bg-blue-500 text-blue-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('kategori.edit', $row->id) }}" class="bg-yellow-100 hover:bg-yellow-500 text-yellow-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteKategori({{ $row->id }})" class="bg-red-100 hover:bg-red-500 text-red-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-semibold">Belum ada kategori</p>
                                <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Form Hapus (Hidden) --}}
<form id="formDelete" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')    
<script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const content = row.innerText.toLowerCase();
            row.style.display = content.includes(keyword) ? '' : 'none';
        });
    });

    // Filter by status
    document.getElementById('filterStatus').addEventListener('change', function () {
        const selectedStatus = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const statusText = row.querySelector('[status]')?.textContent.toLowerCase() || 
                             row.children[4]?.innerText.toLowerCase();
            
            if (selectedStatus === '' || statusText.includes(selectedStatus)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Refresh table
    function refreshTable() {
        location.reload();
    }

    // Delete kategori
    function deleteKategori(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: 'Data yang dihapus tidak dapat dipulihkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                confirmButton: 'font-semibold',
                cancelButton: 'font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/kategori/${id}`;
                
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
</script>
@endpush

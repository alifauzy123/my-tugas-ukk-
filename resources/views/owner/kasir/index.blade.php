@extends('layouts.layoutowner')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-white text-lg"></i>
                </div>
                Master Kasir
            </h1>
            <p class="text-gray-500 mt-2">Kelola semua data kasir dengan mudah</p>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="md:col-span-2">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fas fa-search text-lg"></i>
            </span>
            <input type="text" id="search" placeholder="Cari kasir berdasarkan nama, username, atau nomor HP..." 
                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-sm">
        </div>
    </div>
    <div class="flex gap-2">
        <select id="filterStatus" class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 text-sm">
            <option value="">Semua Status</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
            <option value="rejected">Rejected</option>
        </select>
        <button onclick="refreshTable()" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all text-sm font-semibold border-2 border-gray-200">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-cyan-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Total Kasir</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count($kasir) }}</p>
            </div>
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-cyan-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Approved</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count(array_filter($kasir->toArray(), fn($k) => $k['status'] === 'approved')) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Pending</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count(array_filter($kasir->toArray(), fn($k) => $k['status'] === 'pending')) }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-md border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">Rejected</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ count(array_filter($kasir->toArray(), fn($k) => $k['status'] === 'rejected')) }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
        <p class="text-white font-semibold text-sm">DAFTAR KASIR</p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left font-semibold text-gray-700 w-12">No</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Lengkap</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Username</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">No HP</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-700">Alamat</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                @forelse ($kasir as $k)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200 data-row" data-id="{{ $k->id }}" data-status="{{ strtolower($k->status) }}">
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $k->nama_lengkap }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $k->username }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $k->no_hp }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($k->alamat, 30) ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($k->status === 'approved')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Approved
                                </span>
                            @elseif($k->status === 'rejected')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Rejected
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('owner.kasir.show', $k->id) }}" class="bg-cyan-100 hover:bg-cyan-500 text-cyan-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('owner.kasir.edit', $k->id) }}" class="bg-blue-100 hover:bg-blue-500 text-blue-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteKasir({{ $k->id }})" class="bg-red-100 hover:bg-red-500 text-red-700 hover:text-white p-2 rounded-lg transition-all duration-200 inline-flex items-center justify-center" title="Hapus">
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
                                <p class="text-gray-500 font-semibold">Belum ada data kasir</p>
                                <p class="text-gray-400 text-sm mt-1">Hubungi admin untuk menambahkan data kasir baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const selectedStatus = document.getElementById('filterStatus').value.toLowerCase();
        
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const content = row.innerText.toLowerCase();
            const statusAttr = row.getAttribute('data-status');
            
            const matchesKeyword = content.includes(keyword);
            const matchesStatus = selectedStatus === '' || statusAttr === selectedStatus;
            
            row.style.display = (matchesKeyword && matchesStatus) ? '' : 'none';
        });
    });

    // Filter by status
    document.getElementById('filterStatus').addEventListener('change', function () {
        const selectedStatus = this.value.toLowerCase();
        const keyword = document.getElementById('search').value.toLowerCase();
        
        document.querySelectorAll('#dataTable tr.data-row').forEach(row => {
            const statusAttr = row.getAttribute('data-status');
            const content = row.innerText.toLowerCase();
            
            const matchesKeyword = content.includes(keyword);
            const matchesStatus = selectedStatus === '' || statusAttr === selectedStatus;
            
            row.style.display = (matchesKeyword && matchesStatus) ? '' : 'none';
        });
    });

    // Refresh table
    function refreshTable() {
        location.reload();
    }

    // Delete kasir
    function deleteKasir(id) {
        Swal.fire({
            title: 'Hapus Data Kasir?',
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
                form.action = `/owner/kasir/${id}`;
                
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

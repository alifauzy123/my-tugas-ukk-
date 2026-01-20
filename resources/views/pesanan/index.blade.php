@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pesanan</h1>
        <p class="text-gray-500 mt-2">Kelola semua pesanan Anda di sini</p>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    {{-- Search + Action Bar --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search Input -->
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="search" placeholder="Cari pesanan..." 
                    class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-0 transition-colors">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <button onclick="refreshTable()" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <x-button size="md" variant="primary" href="{{ route('pesanan.create') }}" class="gap-2">
                    <i class="fas fa-plus"></i> Tambah Pesanan
                </x-button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($pesanan->isEmpty())
            <x-empty-state 
                title="Belum Ada Pesanan" 
                icon="fa-inbox"
                message="Tidak ada data pesanan. Mulai dengan membuat pesanan baru.">
                <x-button size="md" variant="primary" href="{{ route('pesanan.create') }}" class="mt-4">
                    <i class="fas fa-plus"></i> Buat Pesanan Baru
                </x-button>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                            <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Kode Pesanan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Kasir</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable" class="divide-y divide-gray-200">
                        @foreach ($pesanan as $p)
                        <tr class="bg-white hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="font-semibold text-gray-900">{{ $p->kode_pesanan }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $p->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $p->kasir->nama_kasir ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statusColor = match($p->status) {
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                        'Diproses' => 'bg-blue-100 text-blue-700',
                                        'Selesai' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <x-action-button href="{{ route('pesanan.show', $p->id) }}" icon="fa-eye" variant="primary" size="sm">
                                        Lihat
                                    </x-action-button>
                                    <x-action-button href="{{ route('pesanan.edit', $p->id) }}" icon="fa-edit" variant="secondary" size="sm">
                                        Edit
                                    </x-action-button>
                                    <button onclick="deletePesanan({{ $p->id }})" class="px-2.5 py-1.5 text-xs font-medium bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr').forEach(row => {
            const content = row.innerText.toLowerCase();
            row.style.display = content.includes(keyword) ? '' : 'none';
        });
    });

    function deletePesanan(id) {
        Swal.fire({
            title: 'Hapus Pesanan?',
            text: 'Data pesanan akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',    
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/pesanan/${id}`;

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

    function refreshTable() {
        location.reload();
    }
</script>
@endpush

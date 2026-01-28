@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kasir.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-white text-lg"></i>
                </div>
                Detail Kasir
            </h1>
            <p class="text-gray-500 mt-2">Informasi lengkap data kasir</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-user-circle"></i>
                    {{ $kasir->nama_lengkap }}
                </h2>
                <p class="text-teal-100 text-sm mt-1">Username: <span class="font-mono">{{ $kasir->username }}</span></p>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                
            
                <!-- Nama Lengkap -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-user text-teal-500"></i>
                        Nama Lengkap
                    </p>
                    <p class="text-lg font-bold text-gray-900">{{ $kasir->nama_lengkap }}</p>
                </div>

                <!-- Email -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-envelope text-teal-500"></i>
                        Email
                    </p>
                    <p class="text-base text-gray-700">{{ $kasir->email }}</p>
                </div>

                <!-- No HP -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-phone text-teal-500"></i>
                        No HP
                    </p>
                    <p class="text-base text-gray-700">{{ $kasir->no_hp }}</p>
                </div>

                <!-- Alamat -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-teal-500"></i>
                        Alamat
                    </p>
                    <p class="text-base text-gray-700 leading-relaxed">{{ $kasir->alamat ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div class="border-b-2 border-gray-100 pb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-teal-500"></i>
                        Status
                    </p>
                    @if($kasir->status === 'approved')
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-check-circle"></i>
                            Approved
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-clock"></i>
                            Pending
                        </span>
                    @endif
                </div>

                <!-- Timestamp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 -mx-8 -mb-8 px-8 py-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                            <i class="fas fa-calendar-plus text-teal-500"></i>
                            Dibuat pada
                        </p>
                        <p class="text-sm font-medium text-gray-900">{{ $kasir->created_at?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $kasir->created_at?->format('H:i:s') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2 flex items-center gap-2">
                            <i class="fas fa-sync-alt text-teal-500"></i>
                            Diperbarui pada
                        </p>
                        <p class="text-sm font-medium text-gray-900">{{ $kasir->updated_at?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $kasir->updated_at?->format('H:i:s') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('kasir.edit', $kasir->id) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-edit"></i>
                Edit/Approve
            </a>
            <button onclick="deleteKasir({{ $kasir->id }})" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
            <a href="{{ route('kasir.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-teal-500"></i>
                Status Kasir
            </h3>
            <div class="space-y-3">
                @if($kasir->status === 'approved')
                    <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            Kasir ini sudah <span class="font-bold">disetujui</span> dan aktif
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-clock text-yellow-600 mr-2"></i>
                            Kasir ini masih <span class="font-bold">menunggu persetujuan</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-list text-teal-500"></i>
                Informasi
            </h3>
            <div class="space-y-3 text-sm text-gray-700">
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">ID Kasir</p>
                    <p class="font-mono text-gray-900">{{ $kasir->id }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs font-semibold mb-1">Username</p>
                    <p class="font-mono text-gray-900">{{ $kasir->username }}</p>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-cyan-50 border-2 border-cyan-200 rounded-lg p-6">
            <h3 class="font-bold text-cyan-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-cyan-500"></i>
                Aksi yang dapat dilakukan
            </h3>
            <ul class="space-y-2 text-sm text-cyan-800">
                <li class="flex gap-2">
                    <span class="text-cyan-500 font-bold">✓</span>
                    <span>Edit/Approve data kasir</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-cyan-500 font-bold">✓</span>
                    <span>Hapus data kasir</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-cyan-500 font-bold">✓</span>
                    <span>Kembali ke daftar kasir</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
                form.action = `/kasir/${id}`;
                
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

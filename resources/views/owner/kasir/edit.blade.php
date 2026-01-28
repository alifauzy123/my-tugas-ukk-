@extends('layouts.layoutowner')

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('owner.kasir.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-700 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-white text-lg"></i>
                </div>
                Approve Data Kasir
            </h1>
            <p class="text-gray-500 mt-2">Validasi data kasir yang baru</p>
        </div>
    </div>
</div>

<!-- Form Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="{{ route('owner.kasir.update', $kasir->id) }}" method="POST" id="formKasir" class="bg-white rounded-lg shadow-lg overflow-hidden">
            @csrf
            @method('PUT')
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-check-square"></i>
                    Review & Approval Kasir
                </h2>
                <p class="text-blue-100 text-sm mt-1">ID: <span class="font-mono">{{ $kasir->id }}</span></p>
            </div>

            <!-- Form Body -->
            <div class="p-8 space-y-6">
                
                <!-- Nama Lengkap -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-user text-blue-500"></i>
                        Nama Lengkap
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->nama_lengkap }}
                    </div>
                </div>

                <!-- Username -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-at text-blue-500"></i>
                        Username
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->username }}
                    </div>
                </div>

                <!-- Email -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-envelope text-blue-500"></i>
                        Email
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->email }}
                    </div>
                </div>

                <!-- No HP -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-phone text-blue-500"></i>
                        No HP
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->no_hp }}
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-500"></i>
                        Tanggal Lahir
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->tanggal_lahir ?? '-' }}
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-venus-mars text-blue-500"></i>
                        Jenis Kelamin
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->jenis_kelamin ?? '-' }}
                    </div>
                </div>

                <!-- Alamat -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-blue-500"></i>
                        Alamat
                    </label>
                    <div class="px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 font-medium">
                        {{ $kasir->alamat ?? '-' }}
                    </div>
                </div>

                <!-- Password -->
                <div class="border-b-2 border-gray-100 pb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <i class="fas fa-lock text-blue-500"></i>
                        Password Baru (Opsional)
                    </label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm">
                    <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-blue-500"></i>
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm">
                        <option value="pending" {{ $kasir->status == 'pending' ? 'selected' : '' }}>
                            <i class="fas fa-clock"></i> Pending
                        </option>
                        <option value="approved" {{ $kasir->status == 'approved' ? 'selected' : '' }}>
                            <i class="fas fa-check-circle"></i> Approved
                        </option>
                        <option value="rejected" {{ $kasir->status == 'rejected' ? 'selected' : '' }}>
                            <i class="fas fa-times-circle"></i> Rejected
                        </option>
                    </select>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-between gap-4 border-t-2 border-gray-100">
                <a href="{{ route('owner.kasir.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="button" id="btnSubmit" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold text-sm flex items-center gap-2 shadow-lg">
                    <i class="fas fa-check"></i> Simpan Status
                </button>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1">
        <!-- Status Info -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>
                Status Saat Ini
            </h3>
            <div class="space-y-3">
                @if($kasir->status === 'approved')
                    <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            Data kasir sudah <span class="font-bold">disetujui</span>
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-clock text-yellow-600 mr-2"></i>
                            Data kasir masih <span class="font-bold">menunggu persetujuan</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i>
                Catatan Approval
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Periksa data kasir dengan cermat</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Ubah status menjadi "Approved" jika valid</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-blue-500 font-bold">✓</span>
                    <span>Jangan setujui data yang tidak lengkap</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('btnSubmit').addEventListener('click', function () {
        const form = document.getElementById('formKasir');
        const status = form.status.value;

        if (!status) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                text: 'Status harus dipilih!',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const message = status === 'approved' 
            ? 'Setujui data kasir ini?' 
            : status === 'rejected' 
                ? 'Tolak data kasir ini?' 
                : 'Simpan status pending?';

        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Simpan!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush

@extends('layouts.layoutkasir')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('pesanan.index') }}" class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Buat Pesanan Baru</h1>
            <p class="text-gray-500 mt-2">Tambahkan pesanan baru ke dalam sistem</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-lg p-8">
        @if($errors->any())
            <div class="mb-6">
                @foreach($errors->all() as $error)
                    <x-alert type="error" message="{{ $error }}" />
                @endforeach
            </div>
        @endif

        <form id="pesananForm" action="{{ route('pesanan.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Kode Pesanan (Auto Generate) --}}
                <x-form-input 
                    label="Kode Pesanan"
                    name="kode_pesanan"
                    type="text"
                    placeholder="Kode otomatis"
                    icon="fa-barcode"
                    disabled
                    readonly />

                {{-- Pelanggan --}}
                <div class="mb-4">
                    <label for="pelanggan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pelanggan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-user"></i>
                        </span>
                        <select name="pelanggan_id" required class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:border-blue-500 focus:ring-0 appearance-none bg-white cursor-pointer {{ $errors->has('pelanggan_id') ? 'border-red-500' : '' }}">
                            <option value="" disabled selected>Pilih Pelanggan</option>
                            @foreach ($pelanggan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                    @if($errors->has('pelanggan_id'))
                        <p class="text-red-500 text-xs font-medium mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('pelanggan_id') }}
                        </p>
                    @endif
                </div>

                {{-- Kasir --}}
                <div class="mb-4">
                    <label for="kasir_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kasir <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-cash-register"></i>
                        </span>
                        <select name="kasir_id" required class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:border-blue-500 focus:ring-0 appearance-none bg-white cursor-pointer {{ $errors->has('kasir_id') ? 'border-red-500' : '' }}">
                            <option value="" disabled selected>Pilih Kasir</option>
                            @foreach ($kasir as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kasir }}</option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                    @if($errors->has('kasir_id'))
                        <p class="text-red-500 text-xs font-medium mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('kasir_id') }}
                        </p>
                    @endif
                </div>

                {{-- Tanggal --}}
                <x-form-input 
                    label="Tanggal Pesanan"
                    name="tanggal"
                    type="date"
                    icon="fa-calendar"
                    required
                    error="{{ $errors->first('tanggal') }}" />

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-flag"></i>
                        </span>
                        <select name="status" required class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:border-blue-500 focus:ring-0 appearance-none bg-white cursor-pointer {{ $errors->has('status') ? 'border-red-500' : '' }}">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                    @if($errors->has('status'))
                        <p class="text-red-500 text-xs font-medium mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('status') }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Catatan (Full Width) --}}
            <div class="mb-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="4" placeholder="Tambahkan catatan atau keterangan khusus..." 
                    class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:border-blue-500 focus:ring-0 resize-none"></textarea>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end items-center gap-3 pt-6 border-t border-gray-200">
                <x-button variant="secondary" href="{{ route('pesanan.index') }}">
                    <i class="fas fa-times"></i> Batal
                </x-button>
                <x-button type="button" id="btnSubmit" variant="primary">
                    <i class="fas fa-save"></i> Simpan Pesanan
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('btnSubmit').addEventListener('click', function () {
    Swal.fire({
      title: 'Simpan Pesanan?',
      text: 'Pastikan semua data sudah benar sebelum menyimpan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3b82f6',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('pesananForm').submit();
      }
    });
  });
</script>
@endpush

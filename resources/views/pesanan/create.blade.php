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

    <div class="mb-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center">
            <i class="fas fa-bell"></i>
        </div>
        <div>
            <p class="text-sm text-blue-900 font-semibold">Mode Kasir</p>
            <p class="text-xs text-blue-700">Pilih pelanggan, sistem akan otomatis mengisi kasir dan status pesanan.</p>
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
                    value="{{ $kode ?? '' }}"
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kasir</label>
                    <div class="flex items-center gap-3 px-4 py-2.5 border-2 border-gray-200 rounded-lg bg-gray-50">
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                            {{ substr(Auth::guard('kasir')->user()->nama_lengkap ?? 'K', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::guard('kasir')->user()->nama_lengkap ?? 'Kasir' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::guard('kasir')->user()->username ?? '-' }}</p>
                        </div>
                    </div>
                    <input type="hidden" name="kasir_id" value="{{ Auth::guard('kasir')->id() }}">
                </div>

                {{-- Tanggal --}}
                <x-form-input 
                    label="Tanggal Pesanan"
                    name="tanggal"
                    type="date"
                    icon="fa-calendar"
                    value="{{ now()->toDateString() }}"
                    required
                    error="{{ $errors->first('tanggal') }}" />

                {{-- Status --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="flex items-center gap-2 px-4 py-2.5 border-2 border-gray-200 rounded-lg bg-gray-50">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-amber-100 text-amber-700">Pending</span>
                        <span class="text-xs text-gray-500">Diatur otomatis saat dibuat</span>
                    </div>
                    <input type="hidden" name="status" value="Pending">
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
      title: 'Simpan Transaksi?',
      text: 'Auto Generate Nota.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3b82f6',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('pesananForm').submit();
      }
    });
  });
</script>
@endpush

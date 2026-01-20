@extends('layouts.layoutkasir')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('pembayaran.index') }}" class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Transaksi Pembayaran</h1>
                <p class="text-[#FFEBEE]">New Data</p>
            </div>
        </div>
    </div>

    <!-- Form Putih -->
    <form action="{{ route('pembayaran.store') }}" method="POST" class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode Pembayaran</label>
                <input type="text" name="kode_pembayaran" readonly placeholder="Kode Generate By System"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>

            <!-- Pilih Pesanan -->
            <div>
                <label class="text-sm font-bold">Pesanan <span class="text-red-500">*</span></label>
                <select name="pesanan_id" id="pesananSelect" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="" disable selected hidden>Pilih Pesanan</option>
                    @foreach ($pesanan as $p)
                        <option value="{{ $p->id }}" data-total="{{ $p->detailPesanan->sum('subtotal') }}">
                            {{ $p->kode_pesanan }} - {{ $p->pelanggan->nama_pelanggan ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Total -->
            <div>
                <label class="text-sm font-bold">Total Pembayaran<span class="text-red-500">*</span></label>
                <input type="text" id="total" name="total" readonly placeholder="Otomatis dari pesanan"
                    class="mt-2 w-full border border-gray-300 rounded-md bg-gray-100 text-sm px-3 py-2 text-gray-600">
            </div>


            <div>
                <label class="text-sm font-bold">Metode<span class="text-red-500">*</span></label>
                <select name="metode" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="" disable selected hidden >Pilih Metode Pembayaran</option>
                    <option value="Tunai" {{ old('metode', $pembayaran->metode ?? '') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="Transfer Bank" {{ old('metode', $pembayaran->metode ?? '') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="E-Wallet" {{ old('metode', $pembayaran->metode ?? '') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>


            <div>
                <label class="text-sm font-bold">Tanggal<span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-bold">Status<span class="text-red-500">*</span></label>
                <select name="status" required class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2">
                    <option value="Dibayar">Dibayar</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Gagal">Gagal</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-bold">Keterangan</label>
                <textarea name="keterangan" rows="3" class="mt-2 w-full border border-gray-300 rounded-md text-sm px-3 py-2" placeholder="Masukkan Keterangan"></textarea>
            </div>

        </div>

        <div class="flex justify-end items-center gap-4 mt-6">
            <button type="button" id="btnSwall" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500 transition duration-200">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
 document.getElementById('btnSwall').addEventListener('click', function () {
    Swal.fire({
      title: 'Apakah Anda Yakin?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',    
      confirmButtonText: 'Ok',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        this.closest('form').submit();
      }
    });
  });
</script>
@endpush
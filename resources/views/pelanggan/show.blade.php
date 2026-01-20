@extends('layouts.app')

@section('content')
<div class="flex flex-col border rounded-md shadow-md w-full bg-[#800000] text-white">

    <!-- Header Merah -->
    <div class="rounded-t-md py-4 px-6 mt-6">
        <div class="flex items-center gap-x-3">
            <a href="{{ route('pelanggan.index') }}" 
                class="py-1.5 px-3 rounded text-[#800000] bg-[#FFEBEE] border border-[#FFEBEE] hover:bg-[#800000] hover:text-white transition-all text-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Master Pelanggan</h1>
                <p class="text-[#FFEBEE]">Detail Data</p>
            </div>
        </div>
    </div>

    <!-- Card Putih -->
    <div class="bg-white text-gray-700 border px-6 py-6 rounded-b-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-bold">Kode</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->kode_pelanggan }}</div>
            </div>

            <div>
                <label class="text-sm font-bold">Nama</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->nama_pelanggan }}</div>
            </div>

            <div>
                <label class="text-sm font-bold">Email</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->email }}</div>
            </div>

            <div>
                <label class="text-sm font-bold">No Telepon</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->no_telp }}</div>
            </div>

            <div>
                <label class="text-sm font-bold">Status</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->status }}</div>
            </div>

            <div>
                <label class="text-sm font-bold">Alamat</label>
                <div class="mt-2 w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2">{{ $pelanggan->alamat }}</div>
            </div>

            

        </div>
    </div>
</div>
@endsection
    
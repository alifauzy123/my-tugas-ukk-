@extends('layouts.app')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700 relative">

    {{-- Search + Aksi --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

        <div class="flex items-center gap-2 w-full md:w-auto">
            {{-- SEARCH --}}
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="search" placeholder="Telusuri..."
                    class="pl-9 pr-3 py-1.5 border-2 border-gray-400 rounded-md w-full focus:outline-none text-sm">
            </div>

            {{-- BUTTONS --}}
            <button id="btnRead" class="hidden px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm">
                <i class="fas fa-eye"></i>
            </button>
            <button id="btnEdit" class="hidden px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm">
                <i class="fas fa-pen"></i>
            </button>
            <button id="btnDelete" class="hidden px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        {{-- CREATE + REFRESH --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('kendaraan.create') }}" class="bg-white border-2 border-red-700 text-red-700 px-4 py-2 rounded-md hover:bg-red-700 hover:text-white text-sm">
                + Create New
            </a>

            <button onclick="refreshTable()" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <table class="w-full text-sm border-2 border-gray-400 rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border-2 border-gray-300">No</th>
                <th class="px-4 py-2 border-2 border-gray-300">Kode</th>
                <th class="px-4 py-2 border-2 border-gray-300">Nama Kendaraan</th>
                <th class="px-4 py-2 border-2 border-gray-300">No Polisi</th>
                <th class="px-4 py-2 border-2 border-gray-300">Supir</th>
                <th class="px-4 py-2 border-2 border-gray-300">Status</th>
            </tr>
        </thead>

        <tbody id="dataTable">
            @forelse ($kendaraan as $index => $row)
                <tr onclick="selectRow(this)" data-id="{{ $row->id }}"
                    class="bg-white hover:bg-yellow-100 cursor-pointer">

                    <td class="px-4 py-2 border-2 border-gray-200">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border-2 border-gray-200">{{ $row->kode_kendaraan }}</td>
                    <td class="px-4 py-2 border-2 border-gray-200">{{ $row->nama_kendaraan }}</td>
                    <td class="px-4 py-2 border-2 border-gray-200">{{ $row->nomer_polisi }}</td>
                    <td class="px-4 py-2 border-2 border-gray-200">{{ $row->supir }}</td>
                    <td class="px-4 py-2 border-2 border-gray-200">{{ $row->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-3">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- FORM DELETE --}}
<form id="formDelete" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@endsection


@push('scripts')
<script>
    let selectedId = null;
    let selectedRow = null;

    function selectRow(row) {
        document.querySelectorAll('#dataTable tr').forEach(r => r.classList.remove('bg-gray-100'));

        row.classList.add('bg-gray-100');
        selectedId = row.getAttribute('data-id');
        selectedRow = row;

        document.getElementById('btnRead').classList.remove('hidden');
        document.getElementById('btnEdit').classList.remove('hidden');
        document.getElementById('btnDelete').classList.remove('hidden');
    }

    // Search
    document.getElementById('search').addEventListener('input', function(){
        const key = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(key) ? '' : 'none';
        });
    });

    // SHOW
    document.getElementById('btnRead').addEventListener('click', function(){
        if (selectedId) window.location.href = `/kendaraan/${selectedId}`;
    });

    // EDIT
    document.getElementById('btnEdit').addEventListener('click', function(){
        if (selectedId) window.location.href = `/kendaraan/${selectedId}/edit`;
    });

    // DELETE
    document.getElementById('btnDelete').addEventListener('click', function(){
        if (!selectedId) return;

        Swal.fire({
            title: 'Yakin hapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
        }).then((result)=>{
            if(result.isConfirmed){
                const form = document.getElementById('formDelete');
                form.action = `/kendaraan/${selectedId}`;
                form.submit();
            }
        });
    });

    function refreshTable(){
        location.reload();
    }
</script>
@endpush

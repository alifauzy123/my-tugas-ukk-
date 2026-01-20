@extends('layouts.layoutkasir')

@section('content')
<div class="bg-white w-full rounded-lg shadow-xl p-6 md:p-12 border-t-[6px] border-red-700 relative">

    {{-- Search + Aksi --}}
   <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="search" placeholder="Telusuri..." 
                class="pl-9 pr-3 py-1.5 border-2 border-gray-400 rounded-md w-full focus:outline-none text-sm">
        </div>
        <button id="btnRead" class="hidden px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm" title="View">
            <i class="fas fa-eye"></i>
        </button>
        <button id="btnEdit" class="hidden px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm" title="Edit">
            <i class="fas fa-pen"></i>
        </button>
        <button id="btnDelete" class="hidden px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm" title="Delete">
            <i class="fas fa-trash"></i>
    </button>
    </div>


        {{-- Jumlah data + Refresh + Create --}}
        <div class="flex items-center gap-2" id="aksiButtons">
            <a href="{{ route('detail_pesanan.create') }}" class="bg-white border-2 border-red-700 text-red-700 px-4 py-2 rounded-md hover:bg-red-700 hover:text-white text-sm">
                + Create New
            </a>
            <button onclick="refreshTable()" class="px-3 py-1 border-2 border-gray-400 text-gray-700 rounded hover:bg-gray-100 text-sm">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    {{-- Tabel --}}
    <table class="w-full text-sm border-2 border-gray-400 rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border-2 border-gray-300">No</th>
                <th class="px-4 py-2 border-2 border-gray-300">Kode</th>
                <th class="px-4 py-2 border-2 border-gray-300">Pesanan</th>
                <th class="px-4 py-2 border-2 border-gray-300">Produk</th>
                <th class="px-4 py-2 border-2 border-gray-300">Qty</th>
                <th class="px-4 py-2 border-2 border-gray-300">Harga</th>
                <th class="px-4 py-2 border-2 border-gray-300">Diskon</th>
                <th class="px-4 py-2 border-2 border-gray-300">Subtotal</th>    
            </tr>
        </thead>
        <tbody id="dataTable">
            @foreach ($detail as $d)
            <tr onclick="selectRow(this)" data-id="{{ $d->id }}" class="bg-white hover:bg-yellow-100 cursor-pointer">
                {{-- <td>ID = {{ $d->id }}</td> --}}
                <td class="px-4 py-2 border-2 border-gray-200">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $d->kode_detail_pesanan }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $d->pesanan->kode_pesanan ?? '-' }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $d->produk->kode_produk ?? '-' }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">{{ $d->qty }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">Rp{{ number_format($d->harga, 0, ',', '.') }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">Rp{{ number_format($d->diskon, 0, ',', '.') }}</td>
                <td class="px-4 py-2 border-2 border-gray-200">Rp{{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    let selectedId = null;
    let selectedRow = null;

    function selectRow(row) {
    const id = row.getAttribute('data-id');

    if (!id || id === 'null') {
        console.warn('ID tidak valid pada baris ini:', row);
        return;
    }

    document.querySelectorAll('#dataTable tr').forEach(r => r.classList.remove('bg-gray-100'));
    row.classList.add('bg-gray-100');
    selectedId = id;
    selectedRow = row;
    ['btnRead', 'btnEdit', 'btnDelete'].forEach(id => document.getElementById(id).classList.remove('hidden'));

    console.log('Baris dipilih, id =', selectedId);
}


    document.addEventListener('click', function (e) {
        const isOutsideClick = !document.getElementById('dataTable').contains(e.target) &&
                       !e.target.closest('#btnRead') &&
                       !e.target.closest('#btnEdit') &&
                       !e.target.closest('#btnDelete');

if (isOutsideClick) {
    selectedId = null;
    if (selectedRow) selectedRow.classList.remove('bg-gray-100');
    ['btnRead', 'btnEdit', 'btnDelete'].forEach(id => document.getElementById(id).classList.add('hidden'));
}

    });

    document.getElementById('btnRead').addEventListener('click', () => {
        if (selectedId) window.location.href = `/detail_pesanan/${selectedId}`;
    });

    document.getElementById('btnEdit').addEventListener('click', () => {
        if (selectedId) window.location.href = `/detail_pesanan/${selectedId}/edit`;
    });

    document.getElementById('search').addEventListener('input', function () {
        
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#dataTable tr').forEach(row => {
            const content = row.innerText.toLowerCase();
            row.style.display = content.includes(keyword) ? '' : 'none';
        });
    });

    document.getElementById('btnDelete').addEventListener('click', () => {
    if (!selectedId || selectedId === 'null') {
        Swal.fire('Gagal', 'Data yang dipilih tidak valid.', 'error');
        return;
    }
    if (selectedId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/detail_pesanan/${selectedId}`;
                form.method = 'POST';

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
});

    function refreshTable() {
        location.reload();
    }
</script>
@endpush

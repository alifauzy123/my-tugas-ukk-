<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    
    // ============================================================
    // AUTO GENERATE KODE SUPPLIER
    // ============================================================
    private function generateKodeSupplier()
    {
        $last = Supplier::orderBy('id', 'DESC')->first();

        if (!$last) {
            return "SUP-001";
        }

        $number = (int) substr($last->kode_supplier, 4) + 1;
        return "SUP-" . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    // ============================================================
    // TAMPIL LIST SUPPLIER
    // ============================================================
    public function index()
{
    // ambil data supplier, 10 per halaman
    $supplier = Supplier::paginate(10);

    // kirim variable bernama $supplier ke view sesuai blade yang kamu pakai
    return view('supplier.index', compact('supplier'));
}


    // ============================================================
    // FORM TAMBAH SUPPLIER
    // ============================================================
    public function create()
    {
        $kodeBaru = $this->generateKodeSupplier();
        return view('supplier.create', compact('kodeBaru'));
    }

    // ============================================================
    // SIMPAN SUPPLIER
    // ============================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'telepon'       => 'nullable|max:15',
            'status'        => 'required',
        ]);

        Supplier::create([
            'kode_supplier' => $this->generateKodeSupplier(),
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'catatan'       => $request->catatan,
            'status'        => $request->status,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    // ============================================================
    // FORM EDIT SUPPLIER
    // ============================================================
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function show($id)
{
    $supplier = Supplier::findOrFail($id);
    return view('supplier.show', compact('supplier'));
}


    // ============================================================
    // UPDATE SUPPLIER
    // ============================================================
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required',
            'telepon'       => 'nullable|max:15',
            'status'        => 'required',
        ]);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'telepon'       => $request->telepon,
            'catatan'       => $request->catatan,
            'status'        => $request->status,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    // ============================================================
    // HAPUS SUPPLIER
    // ============================================================
    public function destroy($id)
    {
        Supplier::destroy($id);
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
